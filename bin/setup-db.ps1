# bin/setup-db.ps1
# Setup/reset database to match production schema (sinkrone_sditat).
# Drop existing DB, recreate empty, run all 37 migrations.
# Safe to run on a fresh DB.
# Requires: .env present with valid DB_* config.

[CmdletBinding()]
param(
    [switch]$Seed,
    [switch]$Force
)

$ErrorActionPreference = 'Stop'
Set-Location $PSScriptRoot\..

function Read-DotEnv($key) {
    if (-not (Test-Path .env)) { return $null }
    Get-Content .env | ForEach-Object {
        if ($_ -match "^$([regex]::Escape($key))=(.*)$") { $matches[1] }
    } | Select-Object -First 1
}

function Require-Cmd($name) {
    if (-not (Get-Command $name -ErrorAction SilentlyContinue)) {
        Write-Error "Required command '$name' not found in PATH"
    }
}

Require-Cmd php
Require-Cmd mysql

if (-not (Test-Path .env)) {
    if (Test-Path .env.example) {
        Copy-Item .env.example .env
        Write-Host "Created .env from .env.example — edit DB_* then re-run." -ForegroundColor Yellow
        exit 0
    } else {
        Write-Error ".env missing and no .env.example to bootstrap from"
    }
}

$dbHost   = Read-DotEnv 'DB_HOST'
$dbPort   = Read-DotEnv 'DB_PORT'
$dbName   = Read-DotEnv 'DB_DATABASE'
$dbUser   = Read-DotEnv 'DB_USERNAME'
$dbPass   = Read-DotEnv 'DB_PASSWORD'

foreach ($kv in @('DB_HOST','DB_DATABASE','DB_USERNAME')) {
    if (-not (Get-Variable ($kv -replace '^DB_','').ToLower() -ErrorAction SilentlyContinue) -or [string]::IsNullOrWhiteSpace((Get-Variable ($kv -replace '^DB_','').ToLower() -ValueOnly))) {
        Write-Error "$kv is empty in .env — fix it then re-run"
    }
}

$portFlag = if ($dbPort) { "--port=$dbPort" } else { '' }
$env:MYSQL_PWD = $dbPass

Write-Host "Testing connection to $dbHost`:$dbPort as $dbUser..." -ForegroundColor Cyan
mysql -h $dbHost $portFlag -u $dbUser -e "SELECT 1;" 2>&1 | Out-Null
if ($LASTEXITCODE -ne 0) {
    Write-Error "MySQL connection failed — check DB_HOST/DB_USERNAME/DB_PASSWORD in .env"
}

if (-not $Force) {
    Write-Host ""
    Write-Host "WARNING: This will DROP and recreate database '$dbName' on $dbHost" -ForegroundColor Yellow
    $confirm = Read-Host "Type the database name to confirm"
    if ($confirm -ne $dbName) {
        Write-Host "Aborted." -ForegroundColor Yellow
        exit 1
    }
}

Write-Host "Dropping database $dbName..." -ForegroundColor Cyan
mysql -h $dbHost $portFlag -u $dbUser -e "DROP DATABASE IF EXISTS ``$dbName``;" 2>&1 | Out-Null
if ($LASTEXITCODE -ne 0) { Write-Error "DROP failed" }

Write-Host "Creating empty database $dbName..." -ForegroundColor Cyan
mysql -h $dbHost $portFlag -u $dbUser -e "CREATE DATABASE ``$dbName`` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" 2>&1 | Out-Null
if ($LASTEXITCODE -ne 0) { Write-Error "CREATE failed" }

Write-Host "Running migrations..." -ForegroundColor Cyan
php artisan config:clear 2>&1 | Out-Null
$migrateArgs = @('migrate:fresh','--force')
if ($Seed) { $migrateArgs += '--seed' }
& php artisan @migrateArgs

if ($LASTEXITCODE -ne 0) {
    Write-Error "Migration failed — schema not applied"
}

Write-Host ""
Write-Host "Done. Database '$dbName' is fresh and matches sinkrone_sditat schema." -ForegroundColor Green
Write-Host "Next: php artisan db:seed --class=SpecificSeeder   (optional)"

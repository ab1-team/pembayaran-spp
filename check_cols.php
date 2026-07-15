<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$cols = Illuminate\Support\Facades\Schema::getColumnListing('users');
echo implode(',', $cols) . PHP_EOL;
echo 'count=' . Illuminate\Support\Facades\DB::table('users')->count() . PHP_EOL;

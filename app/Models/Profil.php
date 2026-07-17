<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Profil extends Model
{
    use HasFactory;
    protected $table = 'profil';
    protected $guarded = ['id'];

    public static function logoDiskPath(): ?string
    {
        $profil = self::first();
        if ($profil && $profil->logo && Storage::disk('public')->exists('logo/' . $profil->logo)) {
            return Storage::disk('public')->path('logo/' . $profil->logo);
        }
        return null;
    }

    public static function logoPath(): string
    {
        return self::logoDiskPath() ?? public_path('assets/img/apple-icon.png');
    }

    public static function logoUrl(): string
    {
        $profil = self::first();
        if ($profil && $profil->logo && Storage::disk('public')->exists('logo/' . $profil->logo)) {
            return asset('storage/logo/' . $profil->logo);
        }
        return asset('assets/img/apple-icon.png');
    }

    public static function namaLembaga(): string
    {
        return self::first()->nama ?? config('app.name');
    }
}
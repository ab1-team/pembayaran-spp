<?php

namespace App\Providers;

use App\Models\Profil;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $profil = Profil::first();

        View::share('appLogoUrl', $profil && $profil->logo
            ? asset('storage/logo/' . $profil->logo)
            : asset('assets/img/apple-icon.png'));

        View::share('appName', $profil->nama ?? config('app.name'));

        View::share('profil', $profil);
    }
}
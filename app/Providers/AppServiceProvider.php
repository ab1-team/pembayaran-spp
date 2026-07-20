<?php

namespace App\Providers;

use App\Models\Profil;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
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
        Paginator::useBootstrapFive();

        $profil = null;
        if (Schema::hasTable('profil')) {
            try {
                $profil = Profil::first();
            } catch (\Throwable $e) {
                $profil = null;
            }
        }

        View::share('appLogoUrl', $profil && $profil->logo
            ? asset('storage/logo/' . $profil->logo)
            : asset('assets/img/apple-icon.png'));

        View::share('appName', $profil->nama ?? config('app.name'));

        View::share('profil', $profil);
    }
}
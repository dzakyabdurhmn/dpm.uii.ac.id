<?php

namespace App\Providers;

use App\Models\Menu;
use App\Models\Setting;
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
        // Halaman situs memakai $siteSettings langsung (judul, hero, kontak),
        // jadi datanya dibagikan ke semua view situs, bukan hanya layout.
        View::composer(['layouts.site', 'site.*'], function ($view): void {
            $view->with('siteSettings', Setting::map());
        });

        View::composer('layouts.site', function ($view): void {
            $view->with('headerMenu', Menu::forLocation('header'));
        });

        View::composer(['layouts.admin', 'admin.*'], function ($view): void {
            $view->with('siteSettings', Setting::map());
        });
    }
}

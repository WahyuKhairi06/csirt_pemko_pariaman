<?php

namespace App\Providers;

use App\View\Composers\SiteComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Data bersama layout publik. View anak ikut didaftarkan agar @section atau blok yang membutuhkan
        // $site, $reportUrl, $emergency, dll. dapat langsung mengaksesnya.
        View::composer([
            'layouts.app',
            'pages.*',
            'services.*',
            'agents.*',
            'documents.*',
            'events.*',
            'advisories.*',
            'posts.*',
            'errors::404',
            'errors.404',
        ], SiteComposer::class);
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
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
        // Force the application to generate HTTPS URLs when the app is
        // running in production or when accessed through a Cloudflare
        // Tunnel (trycloudflare.com). Leave as-is for localhost/http.
        $host = $_SERVER['HTTP_HOST'] ?? null;

        if (app()->environment('production') || ($host && strpos($host, 'trycloudflare.com') !== false)) {
            URL::forceScheme('https');
        }
    }
}

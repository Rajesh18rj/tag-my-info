<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        if (env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register your custom folder for anonymous Blade components
        Blade::anonymousComponentNamespace('new-components', 'new');
    }
}

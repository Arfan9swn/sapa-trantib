<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        \Log::info('AppServiceProvider::register()');
        $this->app->singleton('rateLimiter', function ($app) {
            return new RateLimiter($app->get('cache.store'));
        });
    }
}
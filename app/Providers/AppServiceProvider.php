<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;

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
        // Force HTTPS in production
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // Prevent lazy loading (performance optimization)
        Model::preventLazyLoading(!$this->app->isProduction());

        // Configure rate limiting for company access
        RateLimiter::for('company-access', function (Request $request) {
            return Limit::perMinute(10)->by($request->ip());
        });

        // Configure rate limiting for CV downloads
        RateLimiter::for('cv-download', function (Request $request) {
            return Limit::perMinute(20)->by($request->ip());
        });

        // Configure rate limiting for API/forms
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}

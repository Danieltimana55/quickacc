<?php

namespace App\Providers;

use App\Http\Middleware\CheckRoleMiddleware;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Registrar el middleware de roles como singleton para resolver el problema de binding
        $this->app->singleton('role', function ($app) {
            return new CheckRoleMiddleware;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

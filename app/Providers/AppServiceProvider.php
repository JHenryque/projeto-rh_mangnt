<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
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
        //----------------
        // Gates
        //---------------

        //define a gate that checks if the user is admin
        Gate::define('admin', function () {
            return auth()->user()->role === 'admin';
        });

        //define a gate that checks if the user is rh
        Gate::define('rh', function () {
            return auth()->user()->role === 'rh';
        });

        //define a gate that checks if the user is colaborator
        Gate::define('colaborator', function () {
            return auth()->user()->role === 'colaborator';
        });
    }
}

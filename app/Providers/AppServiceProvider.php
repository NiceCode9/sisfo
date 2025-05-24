<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
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
        view()->composer(
            ['layouts.sidebar'], // Sesuaikan dengan template Anda
            \App\View\Composers\MenuComposer::class
        );

        Gate::before(function ($user, $ability) {
            return $user->hasRole('admin') ? true : null;
        });

        Paginator::useBootstrapFive();
    }
}

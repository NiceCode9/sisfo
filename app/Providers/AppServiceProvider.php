<?php

namespace App\Providers;

use App\Models\GeneralProfile;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
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
        View::composer(['landing.guest', 'landing.index', 'landing.about', 'landing.pendaftaran'], function ($view) {
            $profileSekolah = GeneralProfile::first();
            $view->with('profileSekolah', $profileSekolah);
        });

        Gate::before(function ($user, $ability) {
            return $user->isAdmin() ? true : null;
        });
        view()->composer(
            ['layouts.sidebar'], // Sesuaikan dengan template Anda
            \App\View\Composers\MenuComposer::class
        );

        Paginator::useBootstrapFive();
    }
}

<?php

namespace App\Providers;

use App\Models\Admins\Tour;
use App\Models\Admins\User;
use App\Observers\TourObserver;
use App\Observers\UserObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
        User::observe(UserObserver::class);
        Tour::observe(TourObserver::class);
        Paginator::useBootstrap();
    }
}

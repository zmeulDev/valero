<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\View\Composer\NavigationComposer;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        View::composer('components.navigation', NavigationComposer::class);
    }
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

}
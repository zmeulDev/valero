<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\View\Composers\NavigationComposer;
use App\Models\Article;
use App\Observers\ArticleObserver;
use App\View\Components\ViteAssets;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Update view composer to target all views that might need navigation
        View::composer([
            'layouts.*',
            'components.shared.header',
            'frontend.*'
        ], NavigationComposer::class);

        // Register Article observer
        Article::observe(ArticleObserver::class);

        Blade::component('vite-assets', ViteAssets::class);
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
}

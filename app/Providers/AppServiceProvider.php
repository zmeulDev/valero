<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\View\Composers\NavigationComposer;
use App\Models\Article;
use App\Observers\ArticleObserver;

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
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
}

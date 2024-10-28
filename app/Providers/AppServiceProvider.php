<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\View\Composer\NavigationComposer;
use App\Models\Article;
use App\Observers\ArticleObserver;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        View::composer('components.navigation', NavigationComposer::class);
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

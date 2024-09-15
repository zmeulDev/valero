<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;
use App\Models\Post;

class ViewServiceProvider extends ServiceProvider
{
   // In app/Providers/ViewServiceProvider.php
public function boot()
{
    View::composer('navigation-menu', function ($view) {
        if (auth()->check()) {
            $categories = Category::all();
            $posts = Post::where('is_published', true)->get();
            $view->with('categories', $categories)->with('posts', $posts);
        } else {
            $view->with('categories', collect())->with('posts', collect());
        }
    });
}


    public function register()
    {
        //
    }
}
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer(['layouts.*', 'components.sidebar.*'], function ($view) {
            $view->with('categories', Category::all());
        });
    }
} 
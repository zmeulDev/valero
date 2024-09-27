<?php

namespace App\View\Composer;

use App\Models\Category;
use Illuminate\View\View;
use Exception;

class NavigationComposer
{
    public function compose(View $view)
    {
        try {
            $categories = Category::all();
            $view->with('categories', $categories);
        } catch (Exception $e) {
            report($e);
            $view->with('categories', collect());
        }
    }
}
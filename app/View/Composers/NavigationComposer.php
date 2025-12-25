<?php

namespace App\View\Composers;

use App\Models\Category;
use Illuminate\View\View;
use Exception;

class NavigationComposer
{
    public function compose(View $view): void
    {
        try {
            $view->with([
                'categories' => Category::orderBy('name')->get(),
                'role' => auth()->check() && auth()->user()->role === 'admin',
                'hasPlaylists' => \App\Models\Playlist::exists(),
            ]);
        } catch (Exception $e) {
            report($e);
            $view->with([
                'categories' => collect(),
                'role' => false,
            ]);
        }
    }
}

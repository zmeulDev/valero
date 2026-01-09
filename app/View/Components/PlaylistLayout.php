<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class PlaylistLayout extends Component
{
    public $popularArticles;
    public $categories;

    /**
     * Create a new component instance.
     */
    public function __construct($popularArticles, $categories)
    {
        $this->popularArticles = $popularArticles;
        $this->categories = $categories;
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.playlist');
    }
}

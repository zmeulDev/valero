<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Sidebar extends Component
{
    public $popularArticles;
    public $categories;

    /**
     * Create a new component instance.
     *
     * @param  mixed  $popularArticles
     * @param  mixed  $categories
     * @return void
     */
    public function __construct($popularArticles, $categories)
    {
        $this->popularArticles = $popularArticles;
        $this->categories = $categories;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.sidebar');
    }
}

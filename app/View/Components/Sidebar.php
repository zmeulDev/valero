<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Sidebar extends Component
{
    public $categories;

    public function __construct($categories)
    {
        $this->categories = $categories;
    }

    public function render()
    {
        return view('components.sidebar');
    }
}
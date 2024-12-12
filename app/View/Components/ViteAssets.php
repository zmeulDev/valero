<?php

namespace App\View\Components;

use App\Services\AssetService;
use Illuminate\View\Component;

class ViteAssets extends Component
{
    public $css;
    public $js;

    public function __construct()
    {
        $assets = AssetService::getViteAssets();
        $this->css = $assets['css'];
        $this->js = $assets['js'];
    }

    public function render()
    {
        return view('components.vite-assets');
    }
} 
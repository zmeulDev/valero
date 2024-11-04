<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Setting;

class AdminLayout extends Component
{
    public $settings;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->settings = Setting::getAllSettings();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('layouts.admin', [
            'settings' => $this->settings
        ]);
    }
}
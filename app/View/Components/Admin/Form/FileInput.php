<?php

namespace App\View\Components\Admin\Form;

use Illuminate\View\Component;

class FileInput extends Component
{
    public $name;
    public $label;
    public $currentImage;
    public $required;
    public $accept;
    public $help;

    public function __construct(
        $name,
        $label = null,
        $currentImage = null,
        $required = false,
        $accept = 'image/*',
        $help = null
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->currentImage = $currentImage;
        $this->required = $required;
        $this->accept = $accept;
        $this->help = $help;
    }

    public function render()
    {
        return view('components.admin.form.file-input');
    }
} 
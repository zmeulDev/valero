<?php

namespace App\View\Components\Admin\Form;

use Illuminate\View\Component;

class SearchFilter extends Component
{
    public $options;
    public $searchPlaceholder;
    public $filterLabel;

    public function __construct(
        $options = [],
        $searchPlaceholder = 'Search...',
        $filterLabel = 'Filter'
    ) {
        $this->options = $options;
        $this->searchPlaceholder = $searchPlaceholder;
        $this->filterLabel = $filterLabel;
    }

    public function render()
    {
        return view('components.admin.form.search-filter');
    }
} 
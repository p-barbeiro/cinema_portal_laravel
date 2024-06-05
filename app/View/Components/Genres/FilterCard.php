<?php

namespace App\View\Components\Genres;

use Illuminate\View\Component;

class FilterCard extends Component
{
    public function render()
    {
        return view('components.genres.filter-card');
    }

    public function __construct(
        public string  $filterAction,
        public string  $resetUrl,
        public ?string $name = null,
        public string  $searchPlaceholder = 'Search by name',
    )
    {
    }
}

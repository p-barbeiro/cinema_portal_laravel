<?php

namespace App\View\Components\Customer;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FilterCard extends Component
{
    public function __construct(
        public string  $filterAction,
        public string  $resetUrl,
        public ?string $search = null,
        public string  $searchPlaceholder = 'Search by title, nif, or email'
    )
    {
        //
    }

    public function render(): View
    {
        return view('components.customer.filter-card');
    }
}

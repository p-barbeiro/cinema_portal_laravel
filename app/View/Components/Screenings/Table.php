<?php

namespace App\View\Components\Screenings;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Table extends Component
{
    public function __construct(
        public object $screenings,
    )
    {
    }

    public function render(): View
    {
        return view('components.screenings.table');
    }
}

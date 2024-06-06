<?php

namespace App\View\Components\Screenings;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TableAlt extends Component
{
    public function render(): View
    {
        return view('components.screenings.table-alt');
    }

    public function __construct(
        public object $screenings,
    )
    {
    }
}

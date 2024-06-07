<?php

namespace App\View\Components\Screenings;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SeatMap extends Component
{
    public function render(): View
    {
        return view('components.screenings.seat-map');
    }

    public string $maxRow;

    public function __construct(
        public int  $cols = 1,
        public int  $rows = 1,
    )
    {
        $this->maxRow = chr(65 + $rows);
    }
}

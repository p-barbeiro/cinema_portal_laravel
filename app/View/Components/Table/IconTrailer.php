<?php

namespace App\View\Components\Table;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class IconTrailer extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $href = '#',
        public bool $trailer = true,
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.table.icon-trailer');
    }
}

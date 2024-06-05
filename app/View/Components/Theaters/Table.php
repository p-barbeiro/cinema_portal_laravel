<?php

namespace App\View\Components\Theaters;

use Illuminate\View\Component;

class Table extends Component
{
    public function render()
    {
        return view('components.theaters.table');
    }

    public function __construct(
        public object $theaters,
        public bool   $showEdit = true,
        public bool   $showDelete = true,
    )
    {
    }
}

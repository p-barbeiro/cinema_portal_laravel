<?php

namespace App\View\Components\Users;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Table extends Component
{
    public function __construct(
        public object $users,
        public bool $showView = true,
        public bool $showEdit = true,
        public bool $showDelete = true,
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.users.table');
    }
}

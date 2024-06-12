<?php

namespace App\View\Components\Cart;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Table extends Component
{
    public function render(): View
    {
        return view('components.cart.table');
    }

    public function __construct(
        public object $cart,
    )
    {
    }
}

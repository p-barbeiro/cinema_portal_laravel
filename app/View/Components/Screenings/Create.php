<?php

namespace App\View\Components\Screenings;

use App\Models\Theater;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Create extends Component
{
    public function render(): View
    {
        return view('components.screenings.create-form');
    }
}

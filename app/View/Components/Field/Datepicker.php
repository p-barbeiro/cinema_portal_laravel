<?php

namespace App\View\Components\Field;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Datepicker extends Component
{
    public function render(): View
    {
        return view('components.field.datepicker');
    }

    public function __construct(
        public string $name,
        public string $date,
        public string $label = 'Select Date',
        public string $placeholder = 'Any Date',
        public string $buttonLabel = 'Any Date',
        public string $buttonEnabled = 'true',
    )
    {
    }

}

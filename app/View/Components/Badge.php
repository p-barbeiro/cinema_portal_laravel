<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Badge extends Component
{
    public function __construct(
        public string $text = '',
        public string $type = 'green',
    )
    {
        $this->type = strtolower($type);
        if (!in_array($this->type, ['gray', 'red', 'yellow', 'green', 'blue', 'indigo', 'purple', 'pink'], true)) {
            $this->type = 'green';
        }
    }

    public function render(): View
    {
        return view('components.badge');
    }
}



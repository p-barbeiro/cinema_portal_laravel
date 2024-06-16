<?php

namespace App\View\Components\Users;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FilterCard extends Component
{
    public array $listTypes;

    public function __construct(
        public string $filterAction,
        public string $resetUrl,
        public ?string $name = null,
        public ?string $type = null,
    )
    {
        $this->listTypes = [
            null => 'Any Type',
            'E' => 'Employee',
            'A' => 'Admin'
        ];
    }
    public function render(): View
    {
        return view('components.users.filter-card');
    }
}

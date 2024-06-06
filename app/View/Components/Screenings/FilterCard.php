<?php

namespace App\View\Components\Screenings;

use App\Models\Genre;
use App\Models\Theater;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FilterCard extends Component
{
    public function render(): View
    {
        return view('components.screenings.filter-card');
    }

    public array $listTheaters;

    public function __construct(
        public string  $filterAction,
        public string  $resetUrl,
        public ?string $title = null,
        public ?int    $theater = null,
        public ?string $date = null,
    )
    {
        $theaters = Theater::pluck('name', 'id')?->toArray();
        $this->listTheaters = [null => 'Any Theater'] + $theaters;
    }
}

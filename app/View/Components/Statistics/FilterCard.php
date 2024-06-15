<?php

namespace App\View\Components\Statistics;

use App\Models\Genre;
use App\Models\Theater;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FilterCard extends Component
{
    public array $listTheaters;
    public array $listGenres;

    public function __construct(
        public string  $filterAction,
        public string  $resetUrl,
        public string  $exportUrl,
        public ?string $genre = null,
        public ?int    $theater = null,
        public ?string $startDate = null,
        public ?string $endDate = null,
        public bool    $genreShow = true,
        public bool    $theaterShow = true,
    )
    {
        $genres = Genre::pluck('name', 'code')?->toArray();
        $this->listGenres = (array_merge([null => 'Any Genre'], $genres));

        $theaters = Theater::pluck('name', 'id')?->toArray();
        $this->listTheaters = [null => 'Any Theater'] + $theaters;
    }

    public function render(): View
    {
        return view('components.statistics.filter-card');
    }
}

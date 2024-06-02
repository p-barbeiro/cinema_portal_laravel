<?php

namespace App\View\Components\Movies;

use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FilterCard extends Component
{
    public array $listGenres;
    public array $listYears;

    public function __construct(
        public string  $filterAction,
        public string  $resetUrl,
        public ?string $title = null,
        public ?int    $year = null,
        public ?string $genre = null,
    )
    {
        $genres = Genre::pluck('name', 'code')?->toArray();
        $this->listGenres = (array_merge([null => 'Any Genre'], $genres));

        $years = Movie::pluck('year','year')->unique()->sortDesc()->toArray();
        $this->listYears = [null => 'Any Year']+ $years;

    }

    public function render(): View
    {
        return view('components.movies.filter-card');
    }
}

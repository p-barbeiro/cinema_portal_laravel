<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{

    public static function getMoviesInExhibition()
    {
        return Movie::join('screenings', 'movies.id', '=', 'screenings.movie_id')
            ->where('screenings.date', '>=', now())
            ->where('screenings.date', '<=', now()->addWeeks(2))
            ->select('movies.*')
            ->distinct()
            ->get();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Discipline;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MovieController extends Controller
{

    public function showCase(): View
    {
        $movies = Movie::join('screenings', 'movies.id', '=', 'screenings.movie_id')
            ->where('screenings.date', '>=', now())
            ->where('screenings.date', '<=', now()->addWeeks(2))
            ->select('movies.*')
            ->distinct()
            ->orderBy('movies.title')
            ->with('genre')
            ->get();

        return view('movies.showcase')->with('movies', $movies);
    }

    public function index(): View
    {
        $allMovies = Movie::orderBy('title')->orderBy('year')->with('genre')->paginate(20)->withQueryString();

        return view('movies.index')->with('allMovies', $allMovies);
    }

    public function create(): View
    {
        $movie = new Movie();
        return view('movies.create')
            ->with('movie', $movie);
    }

    public function show(Movie $movie): View
    {
        return view('movies.show')
            ->with('movie', $movie);
    }
}

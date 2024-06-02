<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Discipline;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MovieController extends Controller
{

    public function showCase(): View
    {

        $movies = Movie::whereHas('screenings', function ($query) {
            $query
                ->where('date', '>=', now())
                ->where('date', '<=', now()->addWeeks(2));
        })
            ->orderBy('title')
            ->with('screenings', 'genre', 'screenings.theater')
            ->get();

        return view('movies.showcase')->with('movies', $movies);
    }

    public function index(Request $request): View
    {
        $filterByGenre = $request->genre;
        $filterByYear = $request->year;
        $filterByName = $request->title;

        $moviesQuery = Movie::query();
        if ($filterByGenre !== null) {
            $moviesQuery->where('genre_code', $filterByGenre);
        }
        if ($filterByYear !== null) {
            $moviesQuery->where('year', $filterByYear);
        }
        if ($filterByName !== null) {
            $moviesQuery->where('title', 'LIKE', '%' . $filterByName . '%')
                ->orderBy('year');
        }

        $allMovies = $moviesQuery
            ->orderBy('title')
            ->with('genre')
            ->paginate(20)
            ->withQueryString();

        return view('movies.index', compact('allMovies', 'filterByGenre', 'filterByYear', 'filterByName'));
    }

    public function create(): View
    {
        $movie = new Movie();
        return view('movies.create')
            ->with('movie', $movie);
    }

    public function edit(): View
    {
        $movie = new Movie();
        return view('movies.edit')
            ->with('movie', $movie);
    }

    public function show(Movie $movie): View
    {
        return view('movies.show')
            ->with('movie', $movie);
    }
}

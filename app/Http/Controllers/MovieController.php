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
        return view('movies.showcase');
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

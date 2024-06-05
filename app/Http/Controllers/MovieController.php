<?php

namespace App\Http\Controllers;

use App\Http\Requests\MovieFormRequest;
use App\Models\Movie;
use App\Models\Screening;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MovieController extends \Illuminate\Routing\Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Movie::class);
    }
    public function showCase(Request $request): View
    {

        $filterByGenre = $request->genre;
        $filterByName = $request->title;

        $moviesQuery = Movie::query();
        if ($filterByGenre !== null) {
            $moviesQuery->where('genre_code', $filterByGenre);
        }
        //search by title or synopsis
        if ($filterByName !== null) {
            $moviesQuery->where(function ($query) use ($filterByName) {
                $query
                    ->where('title', 'LIKE', '%' . $filterByName . '%')
                    ->orWhere('synopsis', 'LIKE', '%' . $filterByName . '%');
            })
                ->orderBy('year');
        }

        $movies = $moviesQuery
            ->whereHas('screenings', function ($query) {
                $query
                    ->where('date', '>=', now())
                    ->where('date', '<=', now()->addWeeks(2));
            })
            ->orderBy('title')
            ->with('screenings', 'genre', 'screenings.theater', 'screenings.tickets', 'screenings.theater.seats')
            ->paginate(20)
            ->withQueryString();

        return view('movies.showcase', compact('movies', 'filterByGenre', 'filterByName'));
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
        //search by title
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
        $newMovie = new Movie();
        return view('movies.create')
            ->with('movie', $newMovie);
    }

    public function show(Movie $movie): View
    {
        return view('movies.show')
            ->with('movie', $movie);
    }

    public function edit(Movie $movie): View
    {
        return view('movies.edit')->with('movie', $movie);
    }

    public function update(MovieFormRequest $request, Movie $movie): RedirectResponse
    {
        $movie->update($request->validated());

        if ($request->hasFile('poster_filename')) {
            if ($movie->poster_filename &&
                Storage::fileExists('public/posters/' . $movie->poster_filename)) {
                Storage::delete('public/posters/' . $movie->poster_filename);
            }
            $path = $request->poster_filename->store('public/posters');
            $movie->poster_filename = basename($path);
            $movie->save();
        }

        $htmlMessage = "Movie <span class='font-bold'>'{$movie->title}'</span> has been updated successfully!";
        return redirect()->route('movies.show', ['movie' => $movie])
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function store(MovieFormRequest $request): RedirectResponse
    {
        $newMovie = Movie::create($request->validated());

        if ($request->hasFile('poster_filename')) {
            $path = $request->poster_filename->store('public/posters');
            $newMovie->poster_filename = basename($path);
            $newMovie->save();
        }

        $url = route('movies.show', ['movie' => $newMovie]);
        $htmlMessage = "Movie <a href='$url'><u>{$newMovie->title}</u></a> has been created successfully!";
        return redirect()->route('movies.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function destroy(Movie $movie): RedirectResponse
    {
        try {
            $url = route('movies.show', ['movie' => $movie]);

            $screenings = Screening::where('movie_id', $movie->id)->count();
            if ($screenings == 0) {
                $movie->delete();
                if ($movie->imageExists) {
                    Storage::delete("public/posters/{$movie->poster_filename}");
                }
                $alertType = 'success';
                $alertMsg = "Movie {$movie->title} has been deleted successfully!";
            } else {
                $alertType = 'warning';
                $alertMsg = "Movie '{$movie->title}' cannot be deleted because there are screenings associated.";
            }
        } catch (\Exception $error) {
            $alertType = 'danger';
            $alertMsg = "It was not possible to delete the course
                            '{$movie->title}'
                            because there was an error with the operation!";
        }
        return redirect()->route('movies.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }

    public function destroyImage(Movie $movie): RedirectResponse
    {
        if ($movie->imageExists) {
            Storage::delete("public/posters/{$movie->poster_filename}");
        }
        return redirect()->back()
            ->with('alert-type', 'success')
            ->with('alert-msg', "{$movie->title} poster has been deleted.");
    }
}

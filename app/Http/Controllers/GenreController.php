<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenreFormRequest;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

use Illuminate\Http\Request;

class GenreController extends \Illuminate\Routing\Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Genre::class);
    }

    public function index(): View
    {
        $allGenres = Genre::query()
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('genres.index')->with('genres', $allGenres);
    }

    public function create(): View
    {
        $newGenre = new Genre();
        return view('genres.create')->with('genre', $newGenre);
    }

    public function store(GenreFormRequest $request): RedirectResponse
    {
        $newGenre = Genre::create($request->validated());

        $newGenre->code = strtoupper($newGenre->code);

        $htmlMessage = "Genre '{$newGenre->name}' has been created successfully!";
        return redirect()->route('genres.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function edit(Genre $genre): View
    {
        return view('genres.edit')->with('genre', $genre);
    }

    public function update(GenreFormRequest $request, Genre $genre): RedirectResponse
    {
        $genre->update($request->validated());

        $htmlMessage = "Genre '{$genre->name}' has been updated successfully!";
        return redirect()->route('genres.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function destroy(Genre $genre): RedirectResponse
    {
        try {

            $movies = Movie::where('genre_code', $genre->code)->count();
            if ($movies == 0) {
                $genre->delete();
                $alertType = 'success';
                $alertMsg = "Genre {$genre->name} has been deleted successfully!";
            } else {
                $alertType = 'warning';
                $alertMsg = "Genre '{$genre->name}' cannot be deleted because there are movies associated.";
            }
        } catch (\Exception $error) {
            $alertType = 'danger';
            $alertMsg = "It was not possible to delete the course
                            '{$genre->name}'
                            because there was an error with the operation!";
        }
        return redirect()->route('genres.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }
}

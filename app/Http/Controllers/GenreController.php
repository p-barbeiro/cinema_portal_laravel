<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenreFormRequest;
use App\Models\Genre;
use App\Models\Screening;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GenreController extends \Illuminate\Routing\Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Genre::class);
    }

    public function index(Request $request): View
    {
        $filterByName = $request->name;

        $genresQuery = Genre::query();
        if ($filterByName !== null) {
            $genresQuery
                ->where('name', 'LIKE', '%' . $filterByName . '%');
        }

        $genres = $genresQuery
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('genres.index', compact('genres', 'filterByName'));
    }

    public function create(): View
    {
        $newGenre = new Genre();
        return view('genres.create')->with('genre', $newGenre);
    }

    public function store(GenreFormRequest $request): RedirectResponse
    {
        $newGenre = Genre::create($request->validated());

        // Convert the genre code to uppercase
        $newGenre->code = strtoupper($newGenre->code);
        $newGenre->save();

        $htmlMessage = "Genre <u>$newGenre->name</u> has been created successfully!";
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

        $htmlMessage = "Genre <u>$genre->name</u> has been updated successfully!";
        return redirect()->route('genres.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function destroy(Genre $genre): RedirectResponse
    {
        try {
            //check if there are upcoming screenings for the movies with the genre
            $screenings = Screening::query()
                ->whereHas('movie', function ($query) use ($genre) {
                    $query->where('genre_code', $genre->code);
                })
                ->where('date', '>=', now())->count();
            if ($screenings == 0) {
                $genre->delete();
                $alertType = 'success';
                $alertMsg = "Genre <u>$genre->name</u> has been deleted successfully!";
            } else {
                $alertType = 'warning';
                $alertMsg = "Genre <u>$genre->name</u> cannot be deleted because there are movies with upcoming screenings associated.";
            }
        } catch (\Exception $error) {
            $alertType = 'danger';
            $alertMsg = "It was not possible to delete the genre <u>$genre->name</u> because there was an error with the operation!";
        }
        return redirect()->route('genres.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }
}

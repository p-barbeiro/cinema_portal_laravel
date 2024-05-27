<?php

namespace App\Http\Controllers;
use App\Models\Genre;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function index(): View
    {
        $allGenres = Genre::all();
        return view('genres.index')->with('genres', $allGenres);
    }

    public function create(): View
    {
        $newGenre = new Genre();
        return view('genres.create')->with('genre', $newGenre);
    }

    public function store(Request $request): RedirectResponse
    {
        Genre::create($request->all());
        return redirect()->route('genres.index');
    }

    public function edit(Genre $genre): View
    {
        return view('genres.edit')->with('genre', $genre);
    }

    public function update(Request $request, Genre $genre): RedirectResponse
    {
        $genre->update($request->all());
        return redirect()->route('genres.index');
    }

    public function destroy(Genre $genre): RedirectResponse
    {
        $genre->delete();
        return redirect()->route('genres.index');
    }

    public function show(Genre $genre): View
    {
        return view('genres.show')->with('genre', $genre);
    }
}

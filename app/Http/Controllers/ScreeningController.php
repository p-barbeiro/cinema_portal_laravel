<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScreeningFormRequest;
use App\Models\Movie;
use App\Models\Screening;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ScreeningController extends \Illuminate\Routing\Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Screening::class);
    }

    public function index(Request $request)
    {
        $filterByDate = $request->date;
        $filterByMovie = $request->movie;
        $filterByTheater = $request->theater;

        $screeningsQuery = Screening::query();
        if ($filterByDate !== null) {
            $screeningsQuery->where('date', $filterByDate);
        }
        if ($filterByMovie !== null) {
            $movies = Movie::where('title', 'LIKE', '%' . $filterByMovie . '%')->select('id')->get();
            $screeningsQuery->whereIN('movie_id', $movies);
        }
        if ($filterByTheater !== null) {
            $screeningsQuery->where('theater_id', $filterByTheater);
        }

        $screenings = $screeningsQuery
            ->orderBy('date', 'desc')
            ->orderBy('start_time', 'asc')
            ->with('movie', 'theater', 'tickets')
            ->paginate(50)
            ->withQueryString();

        return view('screenings.index', compact('screenings', 'filterByDate', 'filterByMovie', 'filterByTheater'));
    }

    public function create(): View
    {
        $newScreenings = new Screening();
        return view('screenings.create')->with('screenings', $newScreenings);
    }

    public function store(ScreeningFormRequest $request): RedirectResponse
    {

        $newScreenings = $request->validated();
        Screening::create($request->validated());


        $htmlMessage = "Screening has been created successfully!";
        return redirect()->route('movies.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }
}

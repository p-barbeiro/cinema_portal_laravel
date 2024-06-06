<?php

namespace App\Http\Controllers;

use App\Models\Screening;
use App\Models\Theater;
use App\Models\Ticket;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

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
        if($filterByDate !== null){
            $screeningsQuery->where('date', $filterByDate);
        }
        if($filterByMovie !== null){
            $screeningsQuery->where('movie_id', $filterByMovie);
        }
        if($filterByTheater !== null){
            $screeningsQuery->where('theater_id', $filterByTheater);
        }

        $screenings = $screeningsQuery
            ->orderBy('date', 'desc')
            ->with('movie', 'theater', 'tickets')
            ->paginate(50)
            ->withQueryString();

        return view('screenings.index', compact('screenings', 'filterByDate', 'filterByMovie', 'filterByTheater'));
    }
}

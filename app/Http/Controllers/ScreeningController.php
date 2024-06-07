<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScreeningFormRequest;
use App\Models\Movie;
use App\Models\Screening;
use App\Models\Seat;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        $first_date = Carbon::createFromFormat('Y-m-d', $newScreenings['date']);
        $final_date = $request->date_final ? Carbon::createFromFormat('Y-m-d', $newScreenings['date_final']) : $first_date;
        $movie_name = Movie::find($newScreenings['movie_id'])->title;
        $start_time = $newScreenings['start_time'];

        $screeningsCreated = [];
        $screeningsFailed = [];

        for ($date = $first_date->copy(); $date->lte($final_date); $date->addDay()) {
            $startTime = Carbon::createFromFormat('H:i', $newScreenings['start_time']);

            //nao é possivel adicionar sessoes se existir uma 2 horas antes ou 2 horas depois
            $lastScreeningTime = $startTime->copy()->subHours(3);
            $firstScreeningTime = $startTime->copy()->addHours(3);

            $existingScreening = Screening::where('movie_id', $newScreenings['movie_id'])
                ->where('theater_id', $newScreenings['theater_id'])
                ->whereDate('date', $date->toDateString())
                ->where(function ($query) use ($lastScreeningTime, $firstScreeningTime) {
                    $query->whereTime('start_time', '>=', $lastScreeningTime->toTimeString())
                        ->whereTime('start_time', '<=', $firstScreeningTime->toTimeString());
                })
                ->exists();


            if (!$existingScreening) {
                $screening = Screening::create([
                    'movie_id' => $newScreenings['movie_id'],
                    'theater_id' => $newScreenings['theater_id'],
                    'date' => $date->toDateString(),
                    'start_time' => $newScreenings['start_time'],
                ]);

                $screeningsCreated[] = $screening;
            } else {
                $screeningsFailed[] = $date->format('Y-m-d') . ' : ' . $newScreenings['start_time'];
            }
        }

        $errorMessage = "";
        if (!empty($screeningsFailed)) {
            $errorMessage = "<p>The following screenings failed to create because there are sessions scheduled:</p><ul>";
            foreach ($screeningsFailed as $failedScreening) {
                $errorMessage .= "<li> * <b>$failedScreening</b></li>";
            }
            $errorMessage .= "</ul>";
        }

        $sucessMessage = "";
        if (!empty($screeningsCreated)) {
            $sucessMessage = "Movie <u>$movie_name</u> has now the following new screenings:<ul>";
            foreach ($screeningsCreated as $createdScreening) {
                $sucessMessage .= "<li> * <b>" . $createdScreening->date . ' : ' . $createdScreening->start_time . "</b></li>";
            }
            $sucessMessage .= "</ul>";
        }

        $htmlMessage = $sucessMessage . $errorMessage;

        return redirect()->route('screenings.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function show(Screening $screening): View
    {

        $seatsTaken = Seat::leftJoin('tickets', 'tickets.seat_id', '=', 'seats.id')
            ->where('tickets.screening_id', $screening->id)
            ->selectRaw("CONCAT(seats.row, seats.seat_number) as seat_label")
            ->pluck('seat_label')
            ->toArray();
//        dd($seatsTaken);

        $rows = Seat::where('theater_id', $screening->theater_id)
            ->get()
            ->unique('row')
            ->count();
        $maxRow = chr(65 + $rows);

        $cols = Seat::where('theater_id', $screening->theater_id)
            ->get()
            ->unique('seat_number')
            ->count();

        $seatMap = [];
        for ($col = 0; $col < $cols; $col++) {
            for ($row = 'A'; $row < $maxRow; $row++) {
                $seatMap[$row][$col] = [
                    'id' => "{$row}{$col}",
                    'status' => 'available'
                ];
            }
        }

        foreach ($seatMap as &$seats) {
            $seats = array_map(function ($seat) use ($seatsTaken) {
                if (in_array($seat['id'], $seatsTaken)) {
                    $seat['status'] = 'occupied';
                }
                return $seat;
            }, $seats);
        }

        $screeningId = $screening->id;

//        $soldOutScreenings = DB::table('tickets')
//            ->select('screening_id')
//            ->where('screening_id', $screeningId)
//            ->where('status', 'valid') // Consider only valid tickets
//            ->groupBy('screening_id')
//            ->havingRaw('COUNT(seat_id) >= ?', [Seat::where('theater_id', $screening->theater_id)->count()])
//            ->get();
//        dd($soldOutScreenings);
//        dd($seatMap);

        return view('screenings.show', compact('screening', 'seatMap', 'cols'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\TheaterFormRequest;
use App\Models\Screening;
use App\Models\Seat;
use App\Models\Theater;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TheaterController extends \Illuminate\Routing\Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Theater::class);
    }

    public function index(Request $request)
    {
        $filterByName = $request->name;

        $theatersQuery = Theater::query();
        if ($filterByName !== null) {
            $theatersQuery
                ->where('name', 'LIKE', '%' . $filterByName . '%');
        }

        $theaters = $theatersQuery
            ->orderBy('name')
            ->with('seats')
            ->paginate(10)
            ->withQueryString();

        return view('theaters.index', compact('theaters', 'filterByName'));
    }

    public function create(): View
    {
        $newTheater = new Theater();
        return view('theaters.create')
            ->with('theater', $newTheater);
    }

    public function edit(Theater $theater): View
    {
        return view('theaters.edit')->with('theater', $theater);
    }

    public function store(TheaterFormRequest $request): RedirectResponse
    {
        $newTheater = Theater::create($request->validated());
        //create new seats - rows 'A' to $request->rows and seat_number 0 to $request->cols
        for ($row = 'A'; $row < chr(65 + $request->rows); $row++) {
            for ($seatNumber = 0; $seatNumber < $request->cols; $seatNumber++) {
                Seat::create([
                    'theater_id' => $newTheater['id'],
                    'row' => $row,
                    'seat_number' => $seatNumber
                ]);
            }
        }
        if ($request->hasFile('photo_filename')) {
            $path = $request->photo_filename->store('public/theaters');
            $newTheater->photo_filename = basename($path);
            $newTheater->save();
        }

        $htmlMessage = "Theater <u>$newTheater->name</u> has been created successfully!";
        return redirect()->route('theaters.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function destroy(Theater $theater): RedirectResponse
    {
        try {
            $screenings = Screening::where('theater_id', $theater->id)
                ->where('date', '>=', now())
                ->count();
            if ($screenings == 0) {
                $theater->delete();
                if ($theater->imageExists) {
                    Storage::delete("public/theaters/$theater->photo_filename");
                }
                //for each seat, delete it if it exists
                $theater->seats->each(function ($seat) {
                    $seat->delete();
                });
                $alertType = 'success';
                $alertMsg = "Theater <u>$theater->name</u> has been deleted successfully!";
            } else {
                $alertType = 'warning';
                $alertMsg = "Theater <u>$theater->name</u> cannot be deleted because there are screenings associated.";
            }
        } catch (Exception) {
            $alertType = 'danger';
            $alertMsg = "It was not possible to delete theater <u>$theater->name</u>'
                            because there was an error with the operation!";
        }
        return redirect()->route('theaters.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }

    public function update(TheaterFormRequest $request, Theater $theater): RedirectResponse
    {
        $theater->update($request->validated());
        $htmlMessage = '';
        $alertType = 'success';

        if ($request->hasFile('photo_filename')) {
            if ($theater->photo_filename &&
                Storage::fileExists('public/theaters/' . $theater->photo_filename)) {
                Storage::delete('public/theaters/' . $theater->photo_filename);
            }
            $path = $request->photo_filename->store('public/theaters');
            $theater->photo_filename = basename($path);
            $theater->save();
            $htmlMessage = "<p>The photo of the theater <u>$theater->name</u> has been updated.</p>";
        }

        //if rows and cols are different from the current ones,
        //check is there are screenings associated with the theater and if not,
        //delete the seats and create new ones
        $currentRows = $theater->seats->pluck('row')->unique()->count();
        $currentCols = $theater->seats->pluck('seat_number')->unique()->count();
        if ($request->rows != $currentRows || $request->cols != $currentCols) {
            //check if there are screenings in the future
            $screenings = Screening::where('theater_id', $theater->id)
                ->where('date', '>=', now())
                ->count();

            if ($screenings == 0) {
                //for each seat, delete it if it exists
                $theater->seats->each(function ($seat) {
                    $seat->delete();
                });
                //create new seats - rows 'A' to $request->rows and seat_number 0 to $request->cols
                for ($row = 'A'; $row < chr(65 + $request->rows); $row++) {
                    for ($seatNumber = 0; $seatNumber < $request->cols; $seatNumber++) {
                        //if seat is soft-deleted, restore it
                        $seat = Seat::withTrashed()
                            ->where('theater_id', $theater->id)
                            ->where('row', $row)
                            ->where('seat_number', $seatNumber)
                            ->first();
                        if ($seat) {
                            $seat->restore();
                        } else {
                            Seat::create([
                                'theater_id' => $theater->id,
                                'row' => $row,
                                'seat_number' => $seatNumber
                            ]);
                        }
                    }
                }
                $htmlMessage = "<p>The number of rows and/or columns has been changed.
                        The seats have been updated accordingly.</p>";
            } else {
                $htmlMessage = "<p>The number of rows and/or columns <u>cannot</u> be changed because there are screenings associated in the future.</p>";
                $alertType = 'warning';
            }
        }

        //if name is the same, do nothing
        if ($request->name != $theater->name) {
            $htmlMessage = "<p>The name of the theater has been changed from <u>$theater->name</u> to <u>$request->name</u>.</p>";
        }

        return redirect()->route('theaters.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $htmlMessage);
    }
}

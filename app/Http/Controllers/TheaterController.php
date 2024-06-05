<?php

namespace App\Http\Controllers;

use App\Http\Requests\TheaterFormRequest;
use App\Models\Movie;
use App\Models\Screening;
use App\Models\Seat;
use App\Models\Theater;
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

    public function store(TheaterFormRequest $request): RedirectResponse
    {
        $newTheater = Theater::create($request->validated());
//        $newSeats = Seat::create() TODO Create seats based on $request->rows and $request->cols

        if ($request->hasFile('photo_filename')) {
            $path = $request->photo_filename->store('public/theaters');
            $newTheater->photo_filename = basename($path);
            $newTheater->save();
        }

        $htmlMessage = "Theater <u>{$newTheater->name}</u> has been created successfully!";
        return redirect()->route('theaters.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function destroy(Theater $theater): RedirectResponse
    {
        try {
            $screenings = Screening::where('theater_id', $theater->id)->count();
            if ($screenings == 0) {
                $theater->delete();
                if ($theater->imageExists) {
                    Storage::delete("public/theaters/{$theater->photo_filename}");
                }
                $alertType = 'success';
                $alertMsg = "Theater <u>{$theater->name}</u> has been deleted successfully!";
            } else {
                $alertType = 'warning';
                $alertMsg = "Theater <u>{$theater->name}</u> cannot be deleted because there are screenings associated.";
            }
        } catch (\Exception $error) {
            $alertType = 'danger';
            $alertMsg = "It was not possible to delete theater
                            <u>{$theater->name}</u>'
                            because there was an error with the operation!";
        }
        return redirect()->route('theaters.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }
}

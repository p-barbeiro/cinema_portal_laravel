<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MovieController extends Controller
{

    public function showCase(): View
    {
        return view('movies.showcase');
    }
}

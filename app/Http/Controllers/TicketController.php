<?php

namespace App\Http\Controllers;

use App\Models\Screening;
use App\Models\Ticket;
use Illuminate\View\View;

class TicketController extends Controller
{
    public function show(Ticket $ticket): View
    {
        return view('tickets.show', compact('ticket'));
    }
}

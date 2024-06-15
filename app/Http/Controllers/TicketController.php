<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TicketController extends Controller
{

    public function show(Ticket $ticket): View
    {
        if ($ticket->screening->date < now() && $ticket->screening->start_time < now()->addMinutes(5)->format('H:i')) {
            $ticket->update([
                'status' => 'invalid'
            ]);
        }

        return view('tickets.show', compact('ticket'));
    }

    public function invalidateTicket(Ticket $ticket): RedirectResponse
    {
        $ticket->update([
            'status' => 'invalid'
        ]);

        $htmlMessage = "Ticket has been invalidated successfully!";
        return back()
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function download(Ticket $ticket): \Illuminate\Http\Response
    {
        $qrcode = base64_encode(QrCode::format('svg')->size(100)->errorCorrection('H')->generate($ticket->qrcode_url));
        $pdf = Pdf::loadView('tickets.print', compact('ticket', 'qrcode'));

        return $pdf->download($ticket->id . '.pdf');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Ticket;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class TicketController extends Controller
{
    public static function updateTicketStatus(Ticket $ticket)
    {
        if ($ticket->screening->date < now() && $ticket->screening->start_time < now()->addMinutes(5)->format('H:i')) {
            $ticket->update([
                'status' => 'invalid'
            ]);
        }
    }

    public function show(Ticket $ticket): View
    {
        $this->updateTicketStatus($ticket);

        return view('tickets.show', compact('ticket'));
    }

    public function showSearchForm(): View
    {
        return view('tickets.search');
    }

    public function findTicket(Request $request): RedirectResponse
    {
        $request->validate([
            'ticket_id' => 'required|integer'
        ]);

        $ticket = Ticket::find($request->input('ticket_id'));

        if ($ticket) {
            return redirect()->route('tickets.show', ['ticket' => $ticket->id]);
        } else {
            return back()
                ->with('alert-type', 'info')
                ->with('alert-msg', 'Ticket not found.');
        }
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
        if ($ticket->qrcode_url === null) {
            $url = url()->route('tickets.show', ['ticket' => $ticket->obfuscatedId]);
            $ticket->update([
                'qrcode_url' => $url
            ]);
        }

        $qrcode = base64_encode(QrCode::format('svg')->size(100)->errorCorrection('H')->generate($ticket->qrcode_url));
        $pdf = Pdf::loadView('tickets.print', compact('ticket', 'qrcode'));

        return $pdf->download($ticket->id . '.pdf');
    }


}

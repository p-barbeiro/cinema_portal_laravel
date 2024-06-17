<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Purchase;
use App\Models\Screening;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PurchaseController extends \Illuminate\Routing\Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Purchase::class);
    }

    public function show(Purchase $purchase): View
    {
        $purchase = Purchase::where('id', $purchase->id)
            ->with('tickets', 'tickets.screening', 'tickets.seat', 'tickets.screening.movie')
            ->firstOrFail();

        return view('purchases.receipt', ['purchase' => $purchase]);
    }

    public function index(Customer $customer): View
    {

        $purchases = Purchase::where('customer_id', $customer->id)
            ->orderBy('id', 'desc')
            ->with('tickets', 'tickets.screening', 'tickets.seat', 'tickets.screening.movie')
            ->paginate(8);

        return view('purchases.index', compact('purchases', 'customer'));
    }

    public function downloadReceipt(Purchase $purchase)
    {
        $path = $purchase->receipt_pdf_filename;

        if (!Storage::exists($path)) {
            abort(404);
        }
        return Storage::download($path);
    }

    public function indexTickets(Purchase $purchase): View
    {
        $ticketsQuery = Ticket::query();
        if ($purchase !== null) {
            $ticketsQuery
                ->where('purchase_id', $purchase->id);
        }

        $tickets = $ticketsQuery
            ->orderBy('purchase_id', 'desc')
            ->paginate(10)
            ->withQueryString();

        foreach ($tickets as $ticket) {
            TicketController::updateTicketStatus($ticket);
        }

        return view('tickets.index', compact('tickets', 'purchase'));
    }
}

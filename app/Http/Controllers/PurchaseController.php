<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Spatie\LaravelPdf\Facades\Pdf;

class PurchaseController extends Controller
{
    public function showReceipt(Purchase $purchase): View
    {
        $purchase = Purchase::where('id', $purchase->id)
            ->with('tickets','tickets.screening','tickets.seat', 'tickets.screening.movie')
            ->firstOrFail();

        return view('purchases.receipt', ['purchase' => $purchase]);
    }

    public function index(Request $request): View
    {
        $user = auth()->user();
        $purchases = Purchase::where('customer_id', $user->id)
            ->orderBy('id', 'desc')
            ->with('tickets','tickets.screening','tickets.seat', 'tickets.screening.movie')
            ->paginate(8);
        return view('purchases.index', compact('purchases'));
    }

    public function downloadReceipt(Purchase $purchase)
    {
        $path = $purchase->receipt_pdf_filename;

        if (!Storage::exists($path)) {
            abort(404);
        }
        return Storage::download($path);
    }
}

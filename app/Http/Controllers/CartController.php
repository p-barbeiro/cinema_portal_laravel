<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartConfirmationFormRequest;
use App\Models\Configuration;
use App\Models\Purchase;
use App\Models\Screening;
use App\Models\Seat;
use App\Models\Ticket;
use App\Notifications\PurchaseReceipt;
use App\Services\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CartController extends Controller
{
    public function show(): View
    {
        $cart = session('cart', null);
        $cart = collect($cart);
        return view('cart.show', compact('cart',));
    }

    public function createCart(Collection &$cart, mixed $seats, mixed $price, Screening $screening): Collection
    {
        foreach ($seats as $seat) {
            $seat = Seat::find($seat);
            $data = [
                'id' => $screening->id,
                'theater' => $screening->theater->name,
                'movie' => $screening->movie->title,
                'date' => $screening->date,
                'start_time' => $screening->start_time,
                'seat_number' => $seat->seat_number,
                'row' => $seat->row,
                'seat_id' => $seat->id,
                'price' => $price,
            ];
            $cart->put($screening->id . $seat->id, $data);
        }
        return $cart;
    }

    public function addToCart(Request $request, Screening $screening): RedirectResponse
    {
        $cart = session('cart', collect());

        $price = Configuration::first()->ticket_price;

        $seats = $request->seats;
        if (!$seats) return back();

//        dd($cart->where('id', $screening->id)->pluck('seat_id')->intersect($seats));
        if (!$cart) {
            $cart = collect();
            $cart = $this->createCart($cart, $seats, $price, $screening);
            $request->session()->put('cart', $cart);
        } else {
            if ($cart->where('id', $screening->id)->pluck('seat_id')->intersect($seats)->count() > 0) {
                $alertType = 'warning';
                $htmlMessage = "Seat was not added to the cart because it is already there!";
                return back()
                    ->with('alert-msg', $htmlMessage)
                    ->with('alert-type', $alertType);
            } else {
                $cart = $this->createCart($cart, $seats, $price, $screening);
                $request->session()->put('cart', $cart);
            }
        }

        $alertType = 'success';
        $htmlMessage = "";
        foreach ($seats as $seat) {
            $seat = Seat::find($seat);
            $htmlMessage .= "<p>Seat <u>$seat->row$seat->seat_number</u> was added to the cart.</p>";
        }
        $htmlMessage .= "<p class='text-lg'>If you wish to proceed to the checkout, click <u><a href='" . route('cart.show') . "'>here</a></u></p>";
        return back()
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', $alertType);
    }

    public function removeFromCart(Request $request, Screening $screening): RedirectResponse
    {
        $cart = session('cart', null);
//        dd($cart, $screening, $seat);
        if (!$cart) {
            $alertType = 'warning';
            $htmlMessage = "Seat was not removed from the cart because cart is empty!";
            return back()
                ->with('alert-msg', $htmlMessage)
                ->with('alert-type', $alertType);
        } else {
            $seat = Seat::find($request->remove);
            $element = $cart->get($screening->id . $seat->id);
            if ($element) {
                $cart->forget($screening->id . $seat->id);
                if ($cart->count() == 0) {
                    $request->session()->forget('cart');
                }
                $alertType = 'success';
                $htmlMessage = "Seat <u>$seat->row$seat->seat_number</u> removed from the cart.";
                return back()
                    ->with('alert-msg', $htmlMessage)
                    ->with('alert-type', $alertType);
            } else {
                $alertType = 'warning';
                $htmlMessage = "Seat <u>$seat->row$seat->seat_number</u> was not removed from the cart because cart does not include it!";
                return back()
                    ->with('alert-msg', $htmlMessage)
                    ->with('alert-type', $alertType);
            }
        }
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->session()->forget('cart');
        return back()
            ->with('alert-type', 'success')
            ->with('alert-msg', 'Shopping Cart has been cleared');
    }

    public function payment(): View
    {
        $cart = session('cart', null);
        $cart = collect($cart);
        return view('cart.payment', compact('cart',));
    }

    public function confirm(CartConfirmationFormRequest $request): RedirectResponse
    {
        $cart = session('cart', null);
        if (!$cart || ($cart->count() == 0)) {
            return back()
                ->with('alert-type', 'danger')
                ->with('alert-msg', "Cart was not confirmed, because cart is empty!");
        } else {
            //verify payment method
            if ($request->payment_type == "MBWAY" && $request->payment_ref != null) {
                if (Payment::payWithMBway($request->payment_ref)) {
                    $paymentType = 'MBWAY';
                    $paymentRef = $request->payment_ref;
                } else {
                    return back()
                        ->with('alert-msg', 'MBWay Payment has failed, please try again.')
                        ->with('alert-type', 'danger');
                }
            }
            if ($request->payment_type == "VISA" && $request->payment_ref != null) {
                if (Payment::payWithVisa($request->payment_type, $request->payment_ref)) {
                    $paymentType = 'VISA';
                    $paymentRef = $request->payment_ref;
                    $cvv = $request->cvv;
                } else {
                    return back()
                        ->with('alert-msg', 'VISA Payment has failed, please try again.')
                        ->with('alert-type', 'danger');
                }
            }
            if ($request->payment_type == "PAYPAL" && $request->payment_ref != null) {
                if (Payment::payWithPaypal($request->payment_ref)) {
                    $paymentType = 'PAYPAL';
                    $paymentRef = $request->payment_ref;
                } else {
                    return back()
                        ->with('alert-msg', 'VISA Payment has failed, please try again.')
                        ->with('alert-type', 'danger');
                }
            }
            //payment successful

            //get ticket_price
            $ticket_price = Configuration::first()->ticket_price;
            if (auth()->check()) {
                $ticket_price -= Configuration::first()->registered_customer_ticket_discount;
            }
            $total_price = $cart->count() * $ticket_price;

            //create purchase
            $purchase = Purchase::create([
                'customer_id' => auth()->user()->customer->id ?? null,
                'customer_name' => $request->name,
                'customer_email' => $request->email,
                'nif' => $request->nif,
                'date' => now(),
                'total_price' => $total_price,
                'payment_type' => $paymentType,
                'payment_ref' => $paymentRef,
                'receipt_pdf_filename' => null,
            ]);
            //receipt filename
            $path = 'pdf_purchases/CM-' . $purchase->id . '.pdf';

            // Create tickets
            foreach ($cart as $ticket) {
                $newTicket = Ticket::create(
                    [
                        'screening_id' => $ticket['id'],
                        'seat_id' => $ticket['seat_id'],
                        'purchase_id' => $purchase->id,
                        'price' => $ticket_price,
                    ]
                );
                $url = url()->route('tickets.show', ['ticket' => $newTicket->obfuscatedId]);
                $newTicket->update([
                    'qrcode_url' => $url,
                ]);
            }


            $data = [
                'purchase' => $purchase,
                'img' => public_path() . "/img/receipt_logo.png",
            ];

            $pdf = Pdf::loadView('purchases.receipt', $data);
            Storage::put($path, $pdf->output());

            //update receipt_pdf_filename
            $purchase->update([
                'receipt_pdf_filename' => $path,
            ]);

            $request->session()->forget('cart');


            //send notification
            Notification::route('mail', $purchase->customer_email)
                ->notify(new PurchaseReceipt($purchase));


            return redirect()->route('movies.showcase')
                ->with('alert-type', 'success')
                ->with('alert-msg', "Purchase completed successfully! The receipt was sent to your email.<p>You can open the receipt <a href='" . route('purchases.show', ['purchase' => $purchase->id]) . "'><u>here</u></a>.</p>");

        }
    }

}

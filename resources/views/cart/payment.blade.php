@extends('layouts.main')

@section('main')
    <div class="flex justify-center flex-col sm:flex-row">
        <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden
                    shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50 w-full">
            @if($cart->isEmpty())
                <h3 class="text-xl text-center">Cart is Empty</h3>
            @else
                <div class="flex flex-col">
                    <div class="text-gray-500">Resume:</div>
                    <hr class="my-3">

                    <div class="mt-2 flex flex-row justify-between">
                        <div>
                            Tickets in Cart:
                        </div>
                        <div>
                            {{ $cart->count() }}
                        </div>
                    </div>
                    <div class="mt-2 flex flex-row justify-between">
                        <div class="font-bold">
                            Total:
                        </div>
                        <div>
                            {{ $cart->sum('price') }} €
                        </div>
                    </div>
                </div>
        </div>
        <div class="sm:my-4 sm:ms-5 p-6 bg-white dark:bg-gray-900 overflow-hidden
                    shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50 w-full">

            <div class="text-xl font-bold text-gray-800 dark:text-gray-100">Payment Details</div>
            <form action="{{ route('cart.confirm') }}" method="post">
                @csrf
                <x-field.input class="my-5" name="nif" label="NIF"
                               value="{{ old('nif', Auth::User()?->customer?->nif) }}"/>
                <x-field.radiogroup id="payment_type" name="payment_type" label="Payment Method"
                                    value="{{ old('payment_type', Auth::User()?->customer?->payment_type) }}"
                                    :options="['VISA'=>'VISA', 'MBWAY' => 'MBWAY','PAYPAL'=>'PAYPAL']"/>

                <div class="flex flex-row">
                    <x-field.input id="payment_info" class="mt-5" name="payment_ref" label="Payment Info"
                                   value="{{ old('payment_ref', Auth::User()?->customer?->payment_ref) }}"/>
                    <x-field.input id="cvv" class="mt-5 ms-5 w-1/6" name="cvv" label="CVV"/>
                </div>

                <div class="flex flex-row justify-between">
                    <x-button element="a" type="light" text="Cancel" class="mt-5" href="{{ route('cart.show') }}"/>
                    <x-button element="submit" type="dark" text="Confirm" class="mt-5"/>
                </div>
            </form>
        </div>

        @endif
    </div>
@endsection


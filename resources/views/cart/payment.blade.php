@php
    $ticket_price = \App\Models\Configuration::first()->ticket_price;
    $discount = \App\Models\Configuration::first()->registered_customer_ticket_discount;
    $tickets = $cart->count();
    $auth = auth()->user();
    $customer = $auth?->customer;
@endphp

@extends('layouts.main')

@section('main')
    <div class="flex justify-center flex-col">
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
                            Tickets:
                        </div>
                        <div>
                            {{ $tickets }} x {{$ticket_price}} €
                        </div>
                    </div>
                    @auth
                        <div class="mt-2 flex flex-row justify-between">
                            <div>
                                Discount:
                            </div>
                            <div>
                                - {{number_format($tickets * $discount, 2)}} €
                            </div>
                        </div>
                        <hr class="my-3">
                    @endauth
                    <div class="mt-2 flex flex-row justify-between">
                        <div class="font-bold">
                            Total:
                        </div>
                        <div>
                            {{ $auth?number_format($tickets * ($ticket_price - $discount), 2):number_format($tickets*$ticket_price, 2) }}
                            €

                        </div>
                    </div>
                </div>
        </div>
        <div class="p-6 bg-white dark:bg-gray-900 overflow-hidden
                    shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50 w-full">
            <form action="{{ route('cart.confirm') }}" method="post" class="flex flex-col sm:flex-row justify-between">
                <div class="sm:border-r w-full sm:w-1/2 sm:pe-5">
                    <div class="text-xl font-bold text-gray-800 dark:text-gray-100">Account Information</div>
                    @csrf
                    <x-field.input class="my-5" name="name" label="Name"
                                   value="{{ old('name', $auth?->name) }}"/>

                    <x-field.input class="my-5" name="email" label="Email"
                                   value="{{ old('name', $auth?->email) }}"/>

                    <x-field.input class="mt-5" name="nif" label="NIF"
                                   value="{{ old('nif', $customer?->nif) }}"/>
                </div>

                <div class="w-full sm:w-1/2 sm:ps-5 border-t sm:border-0 mt-5 sm:mt-0 flex flex-col justify-center">
                    <div class="text-xl font-bold text-gray-800 dark:text-gray-100 mt-5 sm:mt-0">Payment Details</div>

                    <x-field.radiogroup id="payment_type" name="payment_type" label="Payment Method"
                                        value="{{ old('payment_type', $customer?->payment_type) }}"
                                        :options="['VISA'=>'VISA', 'MBWAY' => 'MBWAY','PAYPAL'=>'PAYPAL']"
                                        class="my-5"/>
                    @php
                        $label = 'Card Number';
                        if (old('payment_type', $customer?->payment_type) === 'MBWAY') {
                            $label = 'Phone Number';
                        } elseif (old('payment_type', $customer?->payment_type) === 'PAYPAL') {
                            $label = 'Email Address';
                        }
                    @endphp
                    <div class="flex flex-row">
                        <x-field.input id="payment_info" name="payment_ref" label="{{$label}}"
                                       value="{{ old('payment_ref', $customer?->payment_ref) }}"/>
                        <x-field.input id="cvv" class="ms-5 w-1/6 hidden" name="cvv" label="CVV"/>
                    </div>

                    <div class="flex flex-row space-x-5 justify-end">
                        <x-button element="a" type="light" text="Cancel" class="mt-5" href="{{ route('cart.show') }}"/>
                        <x-button element="submit" type="dark" text="Confirm" class="mt-5"/>
                    </div>
                </div>
            </form>
        </div>

        @endif
    </div>
@endsection


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const radioButtons = document.querySelectorAll('input[name="payment_type"]');
        const cvvDiv = document.getElementById('cvv');
        const paymentRefLabel = document.querySelector('label[for="id_payment_ref"]');

        function updatePaymentDetails() {
            radioButtons.forEach(radio => {
                if (radio.checked) {
                    if (radio.value === 'VISA') {
                        cvvDiv.classList.remove('hidden');
                        paymentRefLabel.textContent = 'Card Number';
                    } else if (radio.value === 'MBWAY') {
                        cvvDiv.classList.add('hidden');
                        paymentRefLabel.textContent = 'Phone Number';
                    } else {
                        cvvDiv.classList.add('hidden');
                        paymentRefLabel.textContent = 'Email Address';
                    }
                }
            });
        }

        // Event listener for radio button changes
        radioButtons.forEach(radio => {
            radio.addEventListener('change', updatePaymentDetails);
        });
    });
</script>


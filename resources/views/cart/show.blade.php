@extends('layouts.main')

@section('header-title', 'Shopping Cart')

@section('main')
    <div class="flex justify-center">
        <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden
                    shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50 w-full">
            @if($cart->isEmpty())
                <h3 class="text-xl text-center">Cart is Empty</h3>
            @else
                <div class="flex flex-col">
                    <x-cart.table :cart="$cart"/>

                    <div class="flex flex-row justify-end">
                        <form action="{{ route('cart.destroy') }}" method="post">
                            @csrf
                            @method('DELETE')
                            <x-button element="submit" type="dark" text="Clear Cart" class="mt-4"/>
                        </form>
                    </div>

                </div>

                <div class="mt-12">
                    <div class="flex justify-between space-x-12 items-end">

                        <div>
                            <h3 class="mb-4 text-xl">Proceed to Payment</h3>
                            <form action="{{ route('cart.confirm') }}" method="post">
                                @csrf
                                <x-field.input name="student_number" label="Student Number" width="lg"
                                               :readonly="false"
                                               value="{{ old('student_number', Auth::User()?->student?->number ) }}"/>
                                <x-button element="submit" type="dark" text="Confirm" class="mt-4"/>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

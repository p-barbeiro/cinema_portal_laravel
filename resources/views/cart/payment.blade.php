@extends('layouts.main')

@section('main')
	<div class="flex justify-center">
		<div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden
                    shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50 w-full">
			@if($cart->isEmpty())
				<h3 class="text-xl text-center">Cart is Empty</h3>
			@else
				<div class="flex flex-col">
					<div class="text-xl font-bold text-gray-800 dark:text-gray-100">Payment Details</div>
					<hr class="my-3">
					<form action="{{ route('cart.confirm') }}" method="post">
						@csrf
						<x-field.input class="my-5" name="nif" label="NIF"
									   value="{{ old('nif', Auth::User()?->customer?->nif) }}"/>
						<x-field.radiogroup name="payment_type" label="Payment Method"
											value="{{ old('payment_type', Auth::User()?->customer?->payment_type) }}"
											:options="['VISA'=>'VISA', 'MBWAY' => 'MBWAY','PAYPAL'=>'PAYPAL']"/>
						<x-field.input class="mt-5" name="payment_ref" label="Payment Info"
									   value="{{ old('payment_ref', Auth::User()?->customer?->payment_ref) }}"/>
						<hr class="my-5">
						<x-button element="submit" type="dark" text="Confirm" class="flex flex-row justify-end"/>
					</form>
				</div>
			
			@endif
		</div>
	</div>
@endsection
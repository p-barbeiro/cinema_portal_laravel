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
					<div class="flex flex-row justify-end">
						<form action="{{ route('cart.destroy') }}" method="post">
							@csrf
							@method('DELETE')
							<x-button element="submit" type="light" text="Clear Cart" class="mb-4"/>
						</form>
					</div>
					
					<x-cart.table :cart="$cart"/>
					
					<x-button element="a" type="dark" text="Proceed to payment" class="mt-5 flex flex-row justify-end"
							  href="{{ route('cart.payment') }}"
					/>
				</div>
				
				
			@endif
		</div>
	</div>
@endsection

@extends('layouts.main')

@section('header-title', ($screening?->movie?->title ?? 'Unknown Movie') . " | " . $screening?->date . " | " .date('H:i',strtotime($screening->start_time)) . " | " . ($screening?->theater?->name ?? 'Unknown Theater') )

@section('main')
    <div class="flex flex-col space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
            <div class="max-full">
                <section>

                    <form action="{{ route('cart.add', ['screening' => $screening])}}" method="POST">
                        @csrf

                        <div class="my-5 space-y-4 w-auto">
                            @include('screenings.shared.seatmap', ['seatMap' => $seatMap])
                        </div>

                        <hr>

                        <div class="flex flex-row justify-between mt-5 items-center">

                            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Choose your seats</h2>

                            <x-button element="submit" type="dark" text="Add to Cart"/>

                        </div>

                    </form>

                </section>
            </div>
        </div>
    </div>
@endsection




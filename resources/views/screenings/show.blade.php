@extends('layouts.main')

@section('main')
    <div class="flex flex-col space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
            <div class="max-full">
                <section>
                    <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 p-3 bg-gray-50 border dark:border-gray-700 dark:bg-gray-800 rounded-lg shadow-lg">
                        <div class="md:w-1/6">
                            @if($screening->movie->poster_filename)
                                <img src="{{ $screening->movie->getPoster() }}" alt="{{ $screening->movie->title }}"
                                     class="rounded shadow-lg">
                            @else
                                <div
                                    class="flex items-center justify-center bg-gray-200 dark:bg-gray-700 rounded-lg w-full h-full">
                                    <span class="text-gray-500 dark:text-gray-400">No Poster Available</span>
                                </div>
                            @endif
                        </div>
                        <div class="md:w-5/6 md:pl-6 space-y-3">
                            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-gray-100">{{ $screening?->movie?->title ?? 'Unknown Movie' }}</h1>
                            <p class="text-md text-gray-700 dark:text-gray-300 leading-relaxed">{{ $screening->movie->synopsis }}</p>
                            <div
                                class="flex items-center text-lg text-gray-700 dark:text-gray-300 space-x-2 font-semibold">
                                <span>{{ $screening?->date }}</span>
                                <span>|</span>
                                <span>{{ date('H:i', strtotime($screening->start_time)) }}</span>
                                <span>|</span>
                                <span>Theater: {{ $screening?->theater?->name ?? 'Unknown Theater' }}</span>
                            </div>
                            <div class="absolute bottom-4 right-4 flex space-x-4">
                                <x-button element="a" type="primary" text="Edit" href="{{ route('screenings.edit', ['screening' => $screening]) }}"/>
                                <form method="POST" action="{{ route('screenings.destroy', $screening->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <x-button element="submit" type="danger" text="Delete"/>
                                </form>
                                <x-button element="submit" type="success" text="Verify"/>
                            </div>
                        </div>
                    </div>


                    <hr class="my-5">

                    <form action="{{ route('cart.add', ['screening' => $screening])}}" method="POST">
                        @csrf

                        <div class="flex flex-row justify-between items-center">

                            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Choose your seats: </h2>

                            <x-button element="submit" type="dark" text="Add to Cart"/>

                        </div>

                        <div class="my-5 space-y-4 w-auto">
                            @include('screenings.shared.seatmap', ['seatMap' => $seatMap])
                        </div>

                    </form>

                </section>
            </div>
        </div>
    </div>
@endsection




@extends('layouts.main')

@section('main')
    <div class="flex flex-col space-y-6">
        @if(auth()->check() && (auth()->user()->can('verify', $screening) || auth()->user()->can('update', $screening) || auth()->user()->can('delete', $screening)))
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg flex flex-row justify-start space-x-5">
                <div class="p-2 text-slate-600 dark:text-white">
                    Management:
                </div>
                @can('verify', $screening)
                    @if($screening->start_time > now()->addMinutes(5)->format('H:i') && $screening->date == now()->format('Y-m-d'))
                        @php $validating = session('screening', null) @endphp
                        @if($validating && $validating['id'] == $screening->id)
                            <form action="{{ route('screenings.cancel-verify', ['screening' => $screening])}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <x-button element="submit" type="light" text="Stop Validation" class="p-1"/>
                            </form>
                        @else
                            <form action="{{ route('screenings.verify', ['screening' => $screening])}}" method="POST">
                                @csrf
                                <x-button element="submit" type="dark" text="Enable Tickets Validation"/>
                            </form>
                        @endif
                    @elseif($screening->date < now()->format('Y-m-d'))
                        <div class="p-2 text-slate-800 dark:text-white">Tickets Validation is already closed!</div>
                    @else
                        <div class="p-2 text-slate-800 dark:text-white">Tickets Validation is not open yet! Return on {{date('l, d M Y', strtotime($screening->date))}}</div>
                    @endif
                @endcan

                @can('update', $screening)
                    <x-button element="a" type="light" text="Edit" href="{{ route('screenings.edit', ['screening' => $screening]) }}"/>
                @endcan

                @can('delete', $screening)
                    <form method="POST" action="{{ route('screenings.destroy', $screening->id) }}">
                        @csrf
                        @method('DELETE')
                        <x-button element="submit" type="light" text="Delete"/>
                    </form>
                @endcan
            </div>
        @endif

        <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
            <div class="max-full">
                <section>
                    <div class="relative z-10 flex flex-col md:flex-row space-y-4 md:space-y-0 p-3 bg-gray-50 dark:bg-gray-800 border dark:border-gray-700 rounded-lg shadow-lg">
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
                                <span>{{ date('Y-m-d', strtotime($screening->date))}}</span>
                                <span>|</span>
                                <span>{{ date('H:i', strtotime($screening->start_time)) }}</span>
                                <span>|</span>
                                <span>Theater: {{ $screening?->theater?->name ?? 'Unknown Theater' }}</span>
                            </div>
                            <div class="bottom-4 right-4 flex space-x-4">

                            </div>
                        </div>
                    </div>


                    <hr class="my-5 dark:border-gray-600">

                    <form action="{{ route('cart.add', ['screening' => $screening])}}" method="POST">
                        @csrf

                        @can('use-cart')
                            <div class="flex flex-row justify-between items-center">
                                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Choose your seats: </h2>

                                <x-button element="submit" type="dark" text="Add to Cart"/>
                            </div>
                        @endcan

                        @if(auth()->check() && (Auth::user()->type == 'A' || Auth::user()->type == 'E'))
                            <div class="flex flex-row justify-between items-center">
                                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Theater Current Occupation: </h2>
                            </div>
                        @endif

                        <div class="my-5 space-y-4 w-auto">
                            @include('screenings.shared.seatmap', ['seatMap' => $seatMap])
                        </div>

                    </form>

                </section>
            </div>
        </div>
    </div>
@endsection




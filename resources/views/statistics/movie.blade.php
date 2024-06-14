@extends('layouts.main')

@section('header-title', 'Statistics by Movie')

@section('main')
    <div class="my-4 p-6 bg-white w-full dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
{{--        <x-statistics.filter-card--}}
{{--            filter-action="{{ route('statistics.movie') }}"--}}
{{--            reset-url="{{ route('statistics.movie') }}"--}}
{{--            :genre="old('genre', $filterByGenre)"--}}
{{--            :theater="old('theater', $filterByTheater)"--}}
{{--            :startDate="old('movie', $filterByStartDate)"--}}
{{--            :endDate="old('movie', $filterByEndDate)"--}}
{{--            class="mb-6"--}}
{{--        />--}}

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Genre</th>
                <th>Film</th>
                <th>Total Sales Value</th>
                <th>Total Sales Quantity</th>
                <th>Number of Screenings</th>
                <th>Average Occupied Seats (%)</th>
            </tr>
            </thead>
            <tbody>
            @foreach($salesByFilmAndCategory as $item)
                <tr>
                    <td>{{ $item->genre }}</td>
                    <td>{{ $item->title }}</td>
                    <td>${{ number_format($item->total_value, 2) }}</td>
                    <td>{{ $item->total_quantity }}</td>
                    <td>{{ $item->total_screenings }}</td>
                    <td>{{ number_format($item->average_occupancy, 2) }}%</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $salesByFilmAndCategory->links() }}
    </div>
@endsection

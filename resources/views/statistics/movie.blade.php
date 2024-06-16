@extends('layouts.main')

@php
    if(isset($filterByStartDate)){
        //calc days between start and now()
        $days = (strtotime(date('Y-m-d')) - strtotime($filterByStartDate)) / (60 * 60 * 24);
        $txt = $days==30?' - Last 30 days':'';
    }
@endphp

@section('header-title', 'Statistics by Movie' . $txt)

@section('main')
    <div
        class="my-4 p-6 bg-white w-full dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
        <x-statistics.filter-card :filterAction="route('statistics.movie')"
                                  :resetUrl="route('statistics.movie')"
                                  :exportUrl="route('export.movie.statistics', request()->query())"
                                  :genre="old('genre', $filterByGenre)"
                                  :theater="old('theater', $filterByTheater)"
                                  :startDate="old('start_date', $filterByStartDate)"
                                  :endDate="old('end_date', $filterByEndDate)"
                                  :theaterShow="$theaterShow"
                                  class="mb-6"
        />
        <hr>
        @if($statistics->isEmpty())
            <div class="text-center mt-4 border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
                <p class="text-lg">No movies found.</p>
            </div>
        @else
            <table class="table-auto border-collapse w-full">
                <thead>
                <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
                    <th class="px-2 py-2 text-center">Movie</th>
                    <th class="px-2 py-2 text-center">Genre</th>
                    <th class="px-2 py-2 text-center">Screenings</th>
                    <th class="px-2 py-2 text-center">Tickets Sold</th>
                    <th class="px-2 py-2 text-center">Occupancy Rate (%)</th>
                    <th class="px-2 py-2 text-center">Total Sales</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($statistics as $statistic)
                    <tr class="border-b border-b-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 dark:border-b-gray-500">
                        <td class="px-2 py-2 text-center">{{ $statistic->title }}</td>
                        <td class="px-2 py-2 text-center">{{ $statistic->genre }}</td>
                        <td class="px-2 py-2 text-center">{{ $statistic->total_screenings }}</td>
                        <td class="px-2 py-2 text-center">{{ $statistic->total_quantity }}</td>
                        <td class="px-2 py-2 text-center">{{ number_format($statistic->average_occupancy, 2) }}%</td>
                        <td class="px-2 py-2 text-center">${{ number_format($statistic->total_value, 2) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $statistics->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
@endsection

@extends('layouts.main')

@section('header-title', 'Statistics by Screening')

@section('main')
    <div
        class="my-4 p-6 bg-white w-full dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
        <x-statistics.filter-card :filterAction="route('statistics.screening')"
                                  :resetUrl="route('statistics.screening')"
                                  :genre="old('genre', $filterByGenre)"
                                  :startDate="old('start_date', $filterByStartDate)"
                                  :endDate="old('end_date', $filterByEndDate)"
                                  :theaterShow="$theaterShow"
                                  class="mb-6"
        />
        <hr>
        <table class="table-auto border-collapse w-full">
            <thead>
            <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
                <th class="px-2 py-2 text-center">Screening ID</th>
                <th class="px-2 py-2 text-center">Movie</th>
                <th class="px-2 py-2 text-center">Genre</th>
                <th class="px-2 py-2 text-center">Theater</th>
                <th class="px-2 py-2 text-center">Occupancy Rate (%)</th>
                <th class="px-2 py-2 text-center">Total Sales</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($statistics as $statistic)
                <tr class="border-b border-b-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 dark:border-b-gray-500">
                    <td class="px-2 py-2 text-center">{{ $statistic->screening_id }}</td>
                    <td class="px-2 py-2 text-center">{{ $statistic->movie_title }}</td>
                    <td class="px-2 py-2 text-center">{{ $statistic->genre }}</td>
                    <td class="px-2 py-2 text-center">{{ $statistic->theater_name }}</td>
                    <td class="px-2 py-2 text-center">{{ number_format($statistic->occupancy_rate, 2) }}%</td>
                    <td class="px-2 py-2 text-center">${{ number_format($statistic->total_sales, 2) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $statistics->appends(request()->query())->links() }}
        </div>
    </div>
@endsection

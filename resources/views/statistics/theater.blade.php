@extends('layouts.main')

@section('header-title', 'Statistics by Theater')

@section('main')
    <div
        class="my-4 p-6 bg-white w-full dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
        <x-statistics.filter-card :filterAction="route('statistics.theater')"
                                  :resetUrl="route('statistics.theater')"
                                  :exportUrl="route('export.theater.statistics', request()->query())"
                                  :startDate="old('start_date', $filterByStartDate)"
                                  :endDate="old('end_date', $filterByEndDate)"
                                  :theaterShow="$theaterShow"
                                  :genreShow="$genreShow"
                                  class="mb-6"
        />
        <hr>
        @if($statistics->isEmpty())
            <div
                class="text-center mt-4 border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
                <p class="text-lg">No theaters found.</p>
            </div>
        @else
            <table class="table-auto border-collapse w-full">
                <thead>
                <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
                    <th class="px-2 py-2 text-center">Name</th>
                    <th class="px-2 py-2 text-center">Seats</th>
                    <th class="px-2 py-2 text-center">Tickets Sold</th>
                    <th class="px-2 py-2 text-center">Occupancy Rate (%)</th>
                    <th class="px-2 py-2 text-center">Total Sales</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($statistics as $statistic)
                    <tr class="border-b border-b-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 dark:border-b-gray-500">
                        <td class="px-2 py-2 text-center">{{ $statistic->Theater_Name }}</td>
                        <td class="px-2 py-2 text-center">{{ $statistic->Total_Seats }}</td>
                        <td class="px-2 py-2 text-center">{{ $statistic->Total_Tickets_Sold }}</td>
                        <td class="px-2 py-2 text-center">{{ number_format($statistic->Occupancy_Rate, 2) }}%</td>
                        <td class="px-2 py-2 text-center">${{ number_format($statistic->Total_Sales_Value, 2) }}</td>
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

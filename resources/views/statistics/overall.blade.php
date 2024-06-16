@extends('layouts.main')

@php
    $txt = "";
    if(isset($filterByStartDate)){
        //calc days between start and now()
        $days = (strtotime(date('Y-m-d')) - strtotime($filterByStartDate)) / (60 * 60 * 24);
        $txt = $days==30?' - Last 30 days':'';
    }
@endphp

@section('header-title', 'Overall Statistics' . $txt??'')

@section('main')

    <div class="my-4 p-6 bg-white w-full dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50 text-xs">

        <x-statistics.filter-card :filterAction="route('statistics.overall')"
                                  :resetUrl="route('statistics.overall')"
                                  :exportUrl="route('statistics.export.overall')"
                                  :genre="old('genre', $filterByGenre)"
                                  :theater="old('theater', $filterByTheater)"
                                  :startDate="old('start_date', $filterByStartDate)"
                                  :endDate="old('end_date', $filterByEndDate)"
                                  :genreShow="$genreShow"
                                  :theaterShow="$theaterShow"
                                  class="mb-6"
        />

        <hr class="mb-5">

        <div class="flex space-x-4">
            <div class="w-1/2">

                <table class="table-auto border-collapse w-full">
                    <thead>
                    <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
                        <th colspan="2" class="px-2 py-2 text-center">Overall Sales</th>
                        <th class="px-2 py-2 text-center hidden sm:table-cell"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="border-b border-b-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 dark:border-b-gray-500">
                        <td class="px-2 py-2 text-center">Ticket Sales Value</td>
                        <td class="px-2 py-2 text-center">${{ number_format($totalSalesValue ?? 0, 2) }}</td>
                    </tr>
                    <tr class="border-b border-b-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 dark:border-b-gray-500">
                        <td class="px-2 py-2 text-center">Ticket Sales Quantity</td>
                        <td class="px-2 py-2 text-center">{{ $totalSalesQuantity ?? 0 }} tickets</td>
                    </tr>
                    </tbody>
                </table>

            </div>
            <div class="w-1/2">

                <table class="table-auto border-collapse w-full">
                    <thead>
                    <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
                        <th colspan="2" class="px-2 py-2 text-center">Top Category</th>
                        <th class="px-2 py-2 text-center hidden sm:table-cell"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="border-b border-b-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 dark:border-b-gray-500">
                        <td class="px-2 py-2 text-center">Most Revenue</td>
                        <td class="px-2 py-2 text-center">{{ $categoryMostRevenue->category ?? 'N/A' }} (
                            ${{ number_format($categoryMostRevenue->total_value ?? 0, 2) }} )
                        </td>
                    </tr>
                    <tr class="border-b border-b-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 dark:border-b-gray-500">
                        <td class="px-2 py-2 text-center">Total Ticket Sales</td>
                        <td class="px-2 py-2 text-center">{{ $categoryMostTickets->category ?? 'N/A' }}
                            ( {{ $categoryMostTickets->total_quantity ?? 0 }} tickets )
                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>

        <div class="flex space-x-4 mt-10">
            <div class="w-1/2">

                <table class="table-auto border-collapse w-full">
                    <thead>
                    <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
                        <th colspan="2" class="px-2 py-2 text-center">Top Movie</th>
                        <th class="px-2 py-2 text-center hidden sm:table-cell"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="border-b border-b-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 dark:border-b-gray-500">
                        <td class="px-2 py-2 text-center">Most Revenue</td>
                        <td class="px-2 py-2 text-center">{{ $movieMostRevenue->title ?? 'N/A' }} (
                            ${{ number_format($movieMostRevenue->total_value ?? 0, 2) }} )
                        </td>
                    </tr>
                    <tr class="border-b border-b-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 dark:border-b-gray-500">
                        <td class="px-2 py-2 text-center">Total Ticket Sales</td>
                        <td class="px-2 py-2 text-center">{{ $movieMostTickets->title ?? 'N/A' }}
                            ( {{ $movieMostTickets->total_quantity ?? 0 }} tickets )
                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>
            <div class="w-1/2">

                <table class="table-auto border-collapse w-full">
                    <thead>
                    <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
                        <th colspan="2" class="px-2 py-2 text-center">Top Customer</th>
                        <th class="px-2 py-2 text-center hidden sm:table-cell"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="border-b border-b-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 dark:border-b-gray-500">
                        <td class="px-2 py-2 text-center">Most Spent</td>
                        <td class="px-2 py-2 text-center">{{ $customerMostSpent->customer_name ?? 'N/A' }} (
                            ${{ number_format($customerMostSpent->total_spent ?? 0, 2) }} )
                        </td>
                    </tr>
                    <tr class="border-b border-b-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 dark:border-b-gray-500">
                        <td class="px-2 py-2 text-center">Tickets Bought</td>
                        <td class="px-2 py-2 text-center">{{ $customerMostTickets->customer_name ?? 'N/A' }}
                            ( {{ $customerMostTickets->total_tickets ?? 0 }} tickets )
                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection

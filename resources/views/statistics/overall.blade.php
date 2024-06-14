@extends('layouts.main')

@section('header-title', 'Overall Statistics')

@section('main')
    <div class="my-4 p-6 bg-white w-full dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">

{{--        <x-statistics.filter-card :filterAction="route('statistics.overall')"--}}
{{--                                  :resetUrl="route('statistics.overall')"--}}
{{--                                  :genre="old('genre', $filterByGenre)"--}}
{{--                                  :theater="old('theater', $filterByTheater)"--}}
{{--                                  :startDate="old('movie', $filterByStartDate)"--}}
{{--                                  :endDate="old('movie', $filterByEndDate)"--}}
{{--                                  class="mb-6"--}}
{{--        />--}}

        <hr>

        <div class="mb-4">
            <h2>Overall Sales</h2>
            <p>Total Ticket Sales Value: ${{ number_format($totalSalesValue, 2) }}</p>
            <p>Total Ticket Sales Quantity: {{ $totalSalesQuantity }}</p>
        </div>

        <div class="mb-4">
            <h2>Top Categories</h2>
            <p>Category with Most Revenue: {{ $categoryMostRevenue->category }} ( ${{ number_format($categoryMostRevenue->total_value, 2) }} )</p>
            <p>Category with Most Ticket Sales: {{ $categoryMostTickets->category }} ( {{ $categoryMostTickets->total_quantity }} tickets )</p>
        </div>

        <div class="mb-4">
            <h2>Top Movies</h2>
            <p>Movie with Most Revenue: {{ $movieMostRevenue->title }} ( ${{ number_format($movieMostRevenue->total_value, 2) }} )</p>
            <p>Movie with Most Ticket Sales: {{ $movieMostTickets->title }} ( {{ $movieMostTickets->total_quantity }} tickets )</p>
        </div>

        <div class="mb-4">
            <h2>Top Customers</h2>
            <p>Customer with Most Spent: {{ $customerMostSpent->customer_name }} ( ${{ number_format($customerMostSpent->total_spent, 2) }} )</p>
            <p>Customer with Most Tickets Bought: {{ $customerMostTickets->customer_name }} ( {{ $customerMostTickets->total_tickets }} tickets )</p>
        </div>
    </div>
@endsection

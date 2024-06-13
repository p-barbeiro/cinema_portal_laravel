@extends('layouts.main')

@section('header-title', 'CineMagic Overall Statistics')

@section('main')
    <div class="container mt-5">
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

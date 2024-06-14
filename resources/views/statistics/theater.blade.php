@extends('layouts.main')

@section('header-title', 'Statistics by Theater')

@section('main')
    <div class="my-4 p-6 bg-white w-full dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Theater</th>
                <th>Total Sales Value</th>
                <th>Total Sales Quantity</th>
                <th>Total Seats</th>
                <th>Average Occupied Seats</th>
                <th>Percentage Occupancy (%)</th>
            </tr>
            </thead>
            <tbody>
            @foreach($salesByTheater as $theater)
                <tr>
                    <td>{{ $theater->name }}</td>
                    <td>${{ number_format($theater->total_value, 2) }}</td>
                    <td>{{ $theater->total_quantity }}</td>
                    <td>{{ $theater->total_seats }}</td>
                    <td>{{ number_format($theater->average_occupied_seats, 2) }}</td>
                    <td>{{ number_format($theater->percentage_occupancy, 2) }}%</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $salesByTheater->links() }}
    </div>
@endsection

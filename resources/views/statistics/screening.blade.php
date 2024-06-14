@extends('layouts.main')

@section('header-title', 'Statistics by Screening')

@section('main')
    <div class="my-4 p-6 bg-white w-full dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Screening ID</th>
                <th>Movie</th>
                <th>Date</th>
                <th>Start Time</th>
                <th>Total Sales Value</th>
                <th>Total Sales Quantity</th>
            </tr>
            </thead>
            <tbody>
            @foreach($salesByScreening as $screening)
                <tr>
                    <td>{{ $screening->id }}</td>
                    <td>{{ $screening->movie }}</td>
                    <td>{{ $screening->date }}</td>
                    <td>{{ $screening->start_time }}</td>
                    <td>${{ number_format($screening->total_value, 2) }}</td>
                    <td>{{ $screening->total_quantity }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $salesByScreening->links() }}
    </div>
@endsection

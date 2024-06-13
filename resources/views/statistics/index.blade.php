@extends('layouts.main')

@section('header-title', 'CineMagic Statistics')

@section('main')
    <div class="container mt-5 dark:text-white">
        <h1>CineMagic Statistics</h1>
        <div class="mb-4">
            <h2>Overall Statistics</h2>
            <p>Total Ticket Sales Value: ${{ number_format($totalSalesValue, 2) }}</p>
            <p>Total Ticket Sales Quantity: {{ $totalSalesQuantity }}</p>
        </div>

        <div class="mb-4">
            <h2>Ticket Sales by Month</h2>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Year</th>
                    <th>Month</th>
                    <th>Total Sales Value</th>
                    <th>Total Sales Quantity</th>
                </tr>
                </thead>
                <tbody>
                @foreach($salesByMonth as $month)
                    <tr>
                        <td>{{ $month->year }}</td>
                        <td>{{ $month->month }}</td>
                        <td>${{ number_format($month->total_value, 2) }}</td>
                        <td>{{ $month->total_quantity }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="mb-4">
            <h2>Ticket Sales by Year</h2>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Year</th>
                    <th>Total Sales Value</th>
                    <th>Total Sales Quantity</th>
                </tr>
                </thead>
                <tbody>
                @foreach($salesByYear as $year)
                    <tr>
                        <td>{{ $year->year }}</td>
                        <td>${{ number_format($year->total_value, 2) }}</td>
                        <td>{{ $year->total_quantity }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="mb-4">
            <h2>Ticket Sales by Film</h2>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Film</th>
                    <th>Total Sales Value</th>
                    <th>Total Sales Quantity</th>
                </tr>
                </thead>
                <tbody>
                @foreach($salesByFilm as $film)
                    <tr>
                        <td>{{ $film->title }}</td>
                        <td>${{ number_format($film->total_value, 2) }}</td>
                        <td>{{ $film->total_quantity }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="mb-4">
            <h2>Theater Occupancy Rates</h2>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Theater</th>
                    <th>Total Sales Value</th>
                    <th>Total Sales Quantity</th>
                </tr>
                </thead>
                <tbody>
                @foreach($occupancyRates as $theater)
                    <tr>
                        <td>{{ $theater->name }}</td>
                        <td>${{ number_format($theater->total_value, 2) }}</td>
                        <td>{{ $theater->total_quantity }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

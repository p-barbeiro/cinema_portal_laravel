@extends('layouts.main')

@section('header-title', 'CineMagic Statistics by Customer')

@section('main')
    <div class="container mt-5">
        <h1>Customer Statistics</h1>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Customer</th>
                <th>Total Sales Value</th>
                <th>Total Sales Quantity</th>
            </tr>
            </thead>
            <tbody>
            @foreach($salesByCustomer as $customer)
                <tr>
                    <td>{{ $customer->customer_name }}</td>
                    <td>${{ number_format($customer->total_value, 2) }}</td>
                    <td>{{ $customer->total_quantity }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

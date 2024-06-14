@extends('layouts.main')

@section('header-title', 'Statistics by Customer')

@section('main')
    <div class="my-4 p-6 bg-white w-full dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Customer Name</th>
                <th>Email</th>
                <th>Total Sales Value</th>
                <th>Total Sales Quantity</th>
            </tr>
            </thead>
            <tbody>
            @foreach($salesByCustomer as $customer)
                <tr>
                    <td>{{ $customer->customer_name }}</td>
                    <td>{{ $customer->customer_email }}</td>
                    <td>${{ number_format($customer->total_value, 2) }}</td>
                    <td>{{ $customer->total_quantity }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $salesByCustomer->links() }}
    </div>
@endsection

@extends('layouts.main')

@section('header-title', 'CineMagic Statistics by Category')

@section('main')
    <div class="container mt-5">
        <h1>Category Statistics</h1>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Category</th>
                <th>Total Sales Value</th>
                <th>Total Sales Quantity</th>
            </tr>
            </thead>
            <tbody>
            @foreach($salesByCategory as $category)
                <tr>
                    <td>{{ $category->category }}</td>
                    <td>${{ number_format($category->total_value, 2) }}</td>
                    <td>{{ $category->total_quantity }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

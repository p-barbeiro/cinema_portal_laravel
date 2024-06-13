@extends('layouts.main')

@section('header-title', 'CineMagic Statistics by Movie')

@section('main')
    <div class="container mt-5">
        <h1>Film Statistics</h1>
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
@endsection

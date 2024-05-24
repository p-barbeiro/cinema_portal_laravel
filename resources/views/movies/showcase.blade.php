@extends('layouts.main')

@section('header-title', 'Check out the latest movies!')

@section('main')
    <div class="flex flex-col">
        @each('movies.shared.card', $movies, 'movie')
    </div>
@endsection

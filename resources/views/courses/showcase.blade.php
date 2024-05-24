@extends('layouts.main')

@section('header-title', 'List of Courses')

@section('main')
    <div class="flex flex-col">
        @each('courses.shared.card', $courses, 'movie')
    </div>
@endsection

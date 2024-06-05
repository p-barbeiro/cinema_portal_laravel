@extends('layouts.main')

@section('header-title', 'Check out the latest movies!')

@section('main')
    <div class="my-4 p-6 bg-white w-full dark:bg-gray-900 overflow-hidden
                    shadow sm:rounded-lg text-gray-900 dark:text-gray-50">
    <x-movies.filter-card
        :filterAction="route('movies.showcase')"
        :resetUrl="route('movies.showcase')"
        :genre="old('genre', $filterByGenre)"
        :title="old('title', $filterByName)"
        :yearShow="false"
        :searchPlaceholder="'Search by movie title or synopsis'"
        class="mb-6"
    />
    </div>
    <hr>
    @if($movies->count() > 0)
        <div class="flex flex-col dark:text-gray-50">
            @each('movies.shared.card', $movies, 'movie')
        </div>
    @else
        <div class="flex justify-center font-bold mt-5">No movies found</div>
    @endif
@endsection

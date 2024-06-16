@extends('layouts.main')

@section('header-title', 'All Movies')

@section('main')
    <div class="flex justify-center">
        <div class="my-4 p-6 bg-white w-full dark:bg-gray-900 overflow-hidden
                    shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">

            <x-movies.filter-card
                :filterAction="route('movies.index')"
                :resetUrl="route('movies.index')"
                :genre="old('genre', $filterByGenre)"
                :year="old('year', $filterByYear)"
                :title="old('title', $filterByName)"
                class="mb-6"
            />
            <hr class="dark:border-gray-700">

            @can('create', App\Models\Movie::class)
                <div class="flex justify-end gap-4 my-4">
                    <x-button
                        href="{{ route('movies.create') }}"
                        text="Add movie"
                        type="dark"/>
                </div>
            @endcan

            @if($allMovies->count() > 0)
                <div class="font-base text-sm text-gray-700 dark:text-gray-300">
                    <x-movies.table :movies="$allMovies"
                                    :showView="true"
                                    :showEdit="true"
                                    :showDelete="true"
                    />

                </div>
            <div class="mt-4">
                {{ $allMovies->links() }}
            </div>
            @else
                <div class="flex items-center justify-center font-bold">No movies found</div>
            @endif


        </div>
    </div>
@endsection

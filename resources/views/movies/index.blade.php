@extends('layouts.main')

@section('header-title', 'All Movies')

@section('main')
    <div class="flex justify-center">
        <div class="my-4 p-6 bg-white w-full dark:bg-gray-900 overflow-hidden
                    shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
            @can('create', App\Models\Movie::class)
                <div class="flex items-center gap-4 mb-4">
                    <x-button
                        href="{{ route('movies.create') }}"
                        text="Add a new movie"
                        type="success"/>
                </div>
            @endcan
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
        </div>
    </div>
@endsection

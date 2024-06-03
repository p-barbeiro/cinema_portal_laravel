@extends('layouts.main')

@section('header-title', 'All Genres')

@section('main')
    <div class="flex justify-center">
        <div class="my-4 p-6 bg-white w-full dark:bg-gray-900 overflow-hidden
                    shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">

            @can('create', App\Models\Genre::class)
                <div class="flex justify-end gap-4 my-4">
                    <x-button
                        href="{{ route('genres.create') }}"
                        text="Add Genre"
                        type="secondary"/>
                </div>
            @endcan

            <div class="font-base text-sm text-gray-700 dark:text-gray-300">
                <x-genres.table :genres="$genres"
                                :showEdit="true"
                                :showDelete="true"/>
            </div>
            <div class="mt-4">
                {{ $genres->links() }}
            </div>
        </div>
    </div>
@endsection

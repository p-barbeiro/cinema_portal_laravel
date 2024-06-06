@extends('layouts.main')

@section('header-title', 'All Genres')

@section('main')
    <div class="flex justify-center">

        <div class="my-4 p-6 bg-white w-full dark:bg-gray-900 overflow-hidden
                    shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
            <div>
                <x-genres.filter-card
                    :filterAction="route('genres.index')"
                    :resetUrl="route('genres.index')"
                    :name="old('name', $filterByName)"
                    searchPlaceholder="Search by Genre"
                    class="mb-6"
                />
            </div>

            <hr>
            @can('create', App\Models\Genre::class)
                <div class="flex justify-end gap-4 my-4">
                    <x-button
                        href="{{ route('genres.create') }}"
                        text="Add Genre"
                        type="secondary"/>
                </div>
            @endcan

            @if($genres->count() > 0)
                <div class="font-base text-sm text-gray-700 dark:text-gray-300">
                    <x-genres.table :genres="$genres"
                                    :showEdit="true"
                                    :showDelete="true"/>
                </div>
                <div class="mt-4">
                    {{ $genres->links() }}
                </div>
            @else
                <div class="flex items-center justify-center font-bold">No Genres found</div>
            @endif
        </div>
    </div>
@endsection

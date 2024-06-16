@extends('layouts.main')

@section('header-title', 'All Theaters')

@section('main')
    <div class="flex justify-center">

        <div class="my-4 p-6 bg-white w-full dark:bg-gray-900 overflow-hidden
                    shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
            <div>
                <x-theaters.filter-card
                    :filterAction="route('theaters.index')"
                    :resetUrl="route('theaters.index')"
                    :name="old('name', $filterByName)"
                    searchPlaceholder="Search by Theater"
                    class="mb-6"
                />
            </div>

            <hr class="dark:border-gray-700">

            @can('create', App\Models\Theater::class)
                <div class="flex justify-end gap-4 my-4">
                    <x-button
                        href="{{ route('theaters.create') }}"
                        text="Add New Theater"
                        type="dark"/>
                </div>
            @endcan

            @if($theaters->count() > 0)
                <div class="font-base text-sm text-gray-700 dark:text-gray-300">
                    <x-theaters.table :theaters="$theaters"
                                      :showEdit="true"
                                      :showDelete="true"/>
                </div>
                <div class="mt-4">
                    {{ $theaters->links() }}
                </div>
            @else
                <div class="flex items-center justify-center font-bold">No Theaters found</div>
            @endif

        </div>
    </div>
@endsection

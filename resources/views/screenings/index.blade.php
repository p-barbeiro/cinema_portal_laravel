@extends('layouts.main')

@section('header-title', 'Screenings')

@section('main')

    <div class="flex justify-center">
        <div class="my-4 p-6 bg-white w-full dark:bg-gray-900 overflow-hidden
                    shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">

            <x-screenings.filter-card :filterAction="route('screenings.index')"
                                      :resetUrl="route('screenings.index')"
                                      :date="old('date', $filterByDate)"
                                      :theater="old('theater', $filterByTheater)"
                                      :title="old('movie', $filterByMovie)"
                                      class="mb-6"
            />

            <hr>

            @can('create', App\Models\Screening::class)
                <div class="flex justify-end gap-4 my-4">
                    <x-button
                        href="{{ route('screenings.create') }}"
                        text="Add Screenings"
                        type="secondary"/>
                </div>
            @endcan
{{--                        {{dd($screenings)}}--}}
            @if($screenings->count() > 0)
                <div class="font-base text-sm text-gray-700 dark:text-gray-300">
                    <x-screenings.table-alt :screenings="$screenings"/>
                </div>
                <div class="mt-4">
                    {{ $screenings->links() }}
                </div>
            @else
                <div class="flex items-center justify-center font-bold h-72">No Screenings found</div>
            @endif


        </div>
    </div>
@endsection


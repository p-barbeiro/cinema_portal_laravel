@extends('layouts.main')

@section('header-title', 'Search Ticket')

@section('main')
    <div class="flex justify-center">
        <div class="my-4 p-6 bg-white w-full dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
            <form method="POST" action="{{ route('tickets.search-result') }}" enctype="multipart/form-data">
                @csrf
                <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                    <div class="mt-6 space-y-4">
                        <x-field.input name="ticket_id" label="Ticket ID to find:"
                                       value=""
                                       required="true"/>
                    </div>

                    <div class="flex mt-6">
                        <x-button element="submit" type="dark" text="Search" class="uppercase"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

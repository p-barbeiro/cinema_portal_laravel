@extends('layouts.main')

@section('main')
    <div class="flex flex-col sm:flex-row sm:space-x-5">
        <div class="flex flex-col">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg w-full mt-1 ">
                <div class="flex flex-col">
                    <div class="text-center text-gray-700 dark:text-gray-100">Ticket Status</div>
                    <div class="mt-4">
                        <div class="flex flex-wrap items-center gap-4">
                            <x-badge :type="$ticket->status=='valid'?'green':'red'"
                                     :text="strtoupper($ticket->status)"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg w-full mt-1 ">
                <div class="flex flex-col">
                    <div class="text-center text-gray-700 dark:text-gray-100">Actions</div>
                    <div class="mt-4">
                        <div class="flex flex-wrap items-center gap-4">
                            @if($ticket->status=='valid')
                                <form action="{{ route('tickets.invalidate', ['ticket' => $ticket]) }}" method="POST">
                                    @csrf

                                    <x-button element="submit" type="dark" text="Invalidate Ticket"/>

                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg flex-grow">
            <div class="flex flex-col">
                <div class="flex flex-row justify-between items-baseline border-b">
                    <div class="text-2xl mb-1 text-gray-800 dark:text-gray-200">Ticket Information</div>
                    @if($ticket->status=='valid')
                        <x-table.icon-download text="Download Ticket"
                                               class=" text-gray-800 dark:text-gray-200 inline-flex"
                                               href="{{ route('tickets.download', ['ticket' => $ticket]) }}"/>
                    @endif

                </div>
                <div class="mt-4 flex flex-col-reverse sm:flex-row justify-between">
                    <div class="flex flex-wrap items-center gap-1">
                        <div class="w-full md:w-1/2">
                            <label for="screening"
                                   class="block text-sm font-medium text-gray-700 dark:text-gray-200">Ticket
                                ID</label>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $ticket->id }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <label for="screening"
                                   class="block text-sm font-medium text-gray-700 dark:text-gray-200">Movie</label>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $ticket->screening->movie->title }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <label for="date"
                                   class="block text-sm font-medium text-gray-700 dark:text-gray-200">Date</label>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $ticket->screening->date }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <label for="start_time"
                                   class="block text-sm font-medium text-gray-700 dark:text-gray-200">Start
                                Time</label>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ date('H:i',strtotime($ticket->screening->start_time)) }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <label for="theater"
                                   class="block text-sm font-medium text-gray-700 dark:text-gray-200">Theater</label>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $ticket->screening->theater->name }}</p>
                        </div>
                        <div class="w-full md:w-1/2">
                            <label for="seat"
                                   class="block text-sm font-medium text-gray-700 dark:text-gray-200">Seat</label>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $ticket->seat->row.$ticket->seat->seat_number }}</p>
                        </div>
                    </div>
                    @if($ticket->purchase->customer)
                        <div
                            class="flex flex-col justify-center self-end rounded-lg mb-5 sm:mb-0 w-full p-5 sm:w-1/3 sm:mt-5 sm:h-72">
                            <div class="flex flex-col items-center">
                                <img src="{{ $ticket->purchase?->customer?->user->getPhotoFullUrlAttribute() }}"
                                     alt=""
                                     class="w-40 h-40 rounded-full">
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-5">{{ $ticket->purchase?->customer?->user->name }}</p>
                            </div>

                        </div>
                    @endif
                </div>
            </div>
        </div>
@endsection

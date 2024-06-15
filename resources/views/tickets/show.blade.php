@extends('layouts.main')

@section('main')
    <div class="flex flex-col sm:flex-row sm:space-x-5">

        <!-- Ticket Status -->
        <div class="flex flex-col w-full sm:w-auto">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg w-full mt-1">
                <div class="text-center text-gray-700 dark:text-gray-100 font-semibold">Ticket Status</div>
                <div class="mt-4 flex items-center justify-center">
                    <x-badge :type="$ticket->status == 'valid' ? 'green' : 'red'" :text="ucfirst($ticket->status)"/>
                </div>
            </div>

            <!-- Actions -->
            @if($ticket->status == 'valid')
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg w-full mt-4">
                    <div class="text-center text-gray-700 dark:text-gray-100 font-semibold">Actions</div>
                    <div class="mt-4 flex items-center justify-center">
                        <form action="{{ route('tickets.invalidate', ['ticket' => $ticket]) }}" method="POST">
                            @csrf
                            <x-button element="submit" type="dark" text="Invalidate Ticket"/>
                        </form>
                    </div>
                </div>
            @endif
        </div>

        <!-- Ticket Information -->
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg flex-grow flex justify-center items-center">
            <div class="flex flex-col w-full">
                <div class="flex flex-row justify-between items-baseline border-b">
                    <div class="text-2xl mb-1 text-gray-800 dark:text-gray-200">Ticket Information</div>
                    @if($ticket->status=='valid')
                        <x-table.icon-download text="Download Ticket"
                                               class=" text-gray-800 dark:text-gray-200 inline-flex"
                                               href="{{ route('tickets.download', ['ticket' => $ticket]) }}"/>
                    @endif

                </div>

                <div class="flex flex-row">
                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-y-4 grow">
                        <div class="flex flex-col">
                            <label for="ticket-id" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Ticket
                                ID</label>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $ticket->id }}</p>
                        </div>
                        <div class="flex flex-col">
                            <label for="movie"
                                   class="block text-sm font-medium text-gray-700 dark:text-gray-200">Movie</label>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $ticket->screening->movie->title }}</p>
                        </div>
                        <div class="flex flex-col">
                            <label for="date"
                                   class="block text-sm font-medium text-gray-700 dark:text-gray-200">Date</label>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $ticket->screening->date }}</p>
                        </div>
                        <div class="flex flex-col">
                            <label for="start-time" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Start
                                Time</label>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ date('H:i', strtotime($ticket->screening->start_time)) }}</p>
                        </div>
                        <div class="flex flex-col">
                            <label for="theater" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Theater</label>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $ticket->screening->theater->name }}</p>
                        </div>
                        <div class="flex flex-col">
                            <label for="seat"
                                   class="block text-sm font-medium text-gray-700 dark:text-gray-200">Seat</label>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $ticket->seat->row . $ticket->seat->seat_number }}</p>
                        </div>
                    </div>

                    @if($ticket->purchase->customer)
                        <div class="mt-4 sm:flex sm:items-center sm:justify-between">
                            <div class="flex flex-col items-center sm:items-center sm:gap-4">
                                <img src="{{ $ticket->purchase->customer->user->getPhotoFullUrlAttribute() }}"
                                     alt="{{ $ticket->purchase->customer->user->name }}"
                                     class="w-20 h-20 rounded-full">
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2 sm:mt-0">{{ $ticket->purchase->customer->user->name }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection

@extends('layouts.main')

@section('main')
    <!-- Ticket Status -->
    @can('verify', $ticket->screening)
        @can('verifyTicket', $ticket->screening)
            @if($ticket->status == 'valid')
                <div class="p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg w-full mb-5">
                    <div class="flex items-center justify-center">
                        <form action="{{ route('tickets.invalidate', ['ticket' => $ticket]) }}" method="POST">
                            @csrf
                            <x-button element="submit" type="dark" text="Invalidate Ticket"/>
                        </form>
                    </div>
                </div>
            @endif
        @endcan
        @if($ticket->status == 'valid' && session('screening',null) && session('screening',null)['id'] != $ticket->screening->id)
            <x-alert type="warning" message="Ticket is valid for a different screening."/>
        @endif
    @endcan

    <div class="flex flex-col sm:flex-row sm:space-x-5">


        <!-- Ticket Information -->
        <div class="p-4 sm:p-5 bg-white dark:bg-gray-900 shadow sm:rounded-lg flex-grow flex justify-center items-center">
            <div class="flex flex-col w-full">
                <div class="flex flex-row border-b">
                    <div class="text-2xl mb-1 text-gray-800 dark:text-gray-200 w-5/6">Ticket Information</div>
                    <div class="w-1/6 uppercase">
                        <x-badge :type="$ticket->status == 'valid' ? 'green' : 'red'" :text="$ticket->status"/>
                    </div>
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
                            <div class="flex flex-col items-center sm:items-center sm:gap-4 me-10">
                                <img src="{{ $ticket->purchase->customer->user->getPhotoFullUrlAttribute() }}"
                                     alt="{{ $ticket->purchase->customer->user->name }}"
                                     class="w-20 h-20 rounded-full">
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2 sm:mt-0">{{ $ticket->purchase->customer->user->name }}</p>
                            </div>
                        </div>
                    @endif
                </div>

                <hr class="my-5">
                @can('downloadTicket', \App\Models\User::class)
                    <div class="flex flex-row justify-center">
                        @if($ticket->status=='valid')
                            <x-table.icon-download text="Download Ticket" class="border cursor-pointer p-3 rounded text-gray-800 dark:text-gray-200 inline-flex"
                                                   href="{{ route('tickets.download', ['ticket' => $ticket]) }}"/>
                        @endif
                    </div>
                @endcan
            </div>
        </div>
    </div>

@endsection

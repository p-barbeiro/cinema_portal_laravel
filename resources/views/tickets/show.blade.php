@extends('layouts.main')

@section('main')
    <div class="flex flex-col sm:flex-row sm:space-x-5">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg flex-grow">
            <div class="flex flex-col">
                <div class="text-2xl font-bold text-gray-800 dark:text-gray-100 border-b">Ticket Information</div>
                <div class="mt-4 flex flex-col-reverse sm:flex-row justify-between">
                    <div class="flex flex-wrap items-center gap-4">
                        <div class="w-full md:w-1/2">
                            <label for="screening"
                                   class="block text-sm font-medium text-gray-700 dark:text-gray-200">Ticket ID</label>
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
                    <div class="flex flex-col justify-center self-end sm:h-80 border rounded-lg mb-5 sm:mb-0 w-full sm:w-1/4 p-5">
                        <div class="text-xl text-gray-800 text-center dark:text-gray-100 border-b">Ticket status</div>
                        <div class="mt-4">
                            <div class="flex flex-wrap items-center gap-4">
                                <x-badge :type="$ticket->status=='valid'?'green':'red'"
                                         :text="strtoupper($ticket->status)"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="hidden p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg w-full mt-1 sm:mt-0 sm:w-1/4">
            <div class="flex flex-col">
                <div class="text-2xl font-bold text-gray-800 dark:text-gray-100 border-b">Ticket Status</div>
                <div class="mt-4">
                    <div class="flex flex-wrap items-center gap-4">
                        <x-badge :type="$ticket->status=='valid'?'green':'red'" :text="strtoupper($ticket->status)"/>
                    </div>
                </div>
            </div>
        </div>
@endsection

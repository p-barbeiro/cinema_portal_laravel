@extends('layouts.main')

@section('header-title', 'Purchase ' . $purchase->id . ' - Tickets')

@section('main')
    <div class="flex justify-center">
        <div class="my-4 p-6 bg-white w-full dark:bg-gray-900 overflow-hidden
                    shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">

            @if($tickets->count() > 0)
                <div class="font-base text-sm text-gray-700 dark:text-gray-300">

                    <table class="table-auto border-collapse w-full">
                        <thead>
                        <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
                            <th class="px-2 py-2 text-left">Ticket ID</th>
                            <th class="px-2 py-2 text-left">Movie</th>
                            <th class="px-2 py-2 text-left">Date</th>
                            <th class="px-2 py-2 text-left">Time</th>
                            <th class="px-2 py-2 text-left">Theater</th>
                            <th class="px-2 py-2 text-left">Seat</th>
                            <th class="px-2 py-2 text-center">Status</th>
                            <th class="px-2 py-2 text-left w-10"></th>
                        </thead>

                        <tbody>
                        @foreach ($tickets as $ticket)
                            <tr class="border-b border-b-gray-400 dark:border-b-gray-500 hover:bg-gray-50 dark:hover:bg-gray-800">
                                <td class="px-2 py-2 text-left">
                                    {{ $ticket->id }}
                                </td>

                                <td class="px-2 py-2 text-left">
                                    {{ $ticket->screening->movie->title }}
                                </td>

                                <td class="px-2 py-2 text-left">
                                    {{ date('d/m/y', strtotime($ticket->screening->date)) }}
                                </td>

                                <td class="px-2 py-2 text-left">
                                    {{ date('H:i', strtotime($ticket->screening->start_time)) }}
                                </td>

                                <td class="px-2 py-2 text-left">
                                    {{ $ticket->screening->theater->name }}
                                </td>

                                <td class="px-2 py-2 text-left">
                                    {{ $ticket->seat->row }}{{ $ticket->seat->seat_number }}
                                </td>

                                <td class="px-2 py-2 text-left uppercase">
                                    <x-badge :type="$ticket->status=='valid'?'green':'red'"
                                             :text="strtoupper($ticket->status)"/>
                                </td>

                                <td class="px-2 py-2 text-center align-middle">
                                    <div class="inline-block">
                                        <x-table.icon-open :version=1 class="px-0.5"
                                                           href="{{ route('tickets.show', ['ticket' => $ticket]) }}"/>
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
                <div class="mt-4">
                    {{ $tickets->links() }}
                </div>
            @else
                <div class="flex justify-center font-bold">No Tickets found</div>
            @endif

        </div>
    </div>
@endsection

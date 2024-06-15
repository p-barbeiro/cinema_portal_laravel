@extends('layouts.main')

@section('header-title', $customer->user->name . ' - Purchases')

@section('main')
    <div class="flex justify-center">
        <div class="my-4 p-6 bg-white w-full dark:bg-gray-900 overflow-hidden
                    shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">

            @if($purchases->count() > 0)
                <div class="font-base text-sm text-gray-700 dark:text-gray-300">

                    <table class="table-auto border-collapse w-full">
                        <thead>
                        <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
                            <th class="px-2 py-2 text-left">Purchase Date</th>
                            <th class="px-2 py-2 text-left">Tickets</th>
                            <th class="px-2 py-2 text-left">Total Price</th>
                            <th class="px-2 py-2 text-center sm:table-cell hidden">Tickets</th>
                            <th class="px-2 py-2 text-center">Receipt</th>
                            <th class="px-2 py-2 text-center">Download</th>

                        </thead>
                        <tbody>
                        @foreach ($purchases as $purchase)
                            <tr class="border-b border-b-gray-400 dark:border-b-gray-500 hover:bg-gray-50 dark:hover:bg-gray-800">
                                <td class="px-2 py-2 text-left">
                                    {{ date('d/m/y', strtotime($purchase->date)) }}
                                </td>
                                <td class="px-2 py-2 text-left sm:table-cell hidden">
                                    {{ $purchase->tickets->count() }}
                                </td>
                                <td class="px-2 py-2 text-left">
                                    {{ $purchase->total_price }} €
                                </td>

                                <td class="px-2 py-2 text-center align-middle">
                                    <div class="inline-block">
                                        <x-table.icon-open class="px-0.5"
                                                           href="{{ route('tickets.index', ['purchase' => $purchase ]) }}"/>
                                    </div>

                                </td>

                                <td class="px-2 py-2 text-center align-middle">
                                    <div class="inline-block">
                                        <x-table.icon-open :version=2 class="px-0.5"
                                                           href="{{ route('purchases.show', ['purchase' => $purchase]) }}"/>
                                    </div>
                                </td>

                                <td class="px-2 py-2 text-center align-middle">
                                    <div class="inline-block">
                                        @if($purchase->receipt_pdf_filename)
                                            <x-table.icon-download class="px-0.5" text=""
                                                                   href="{{ route('purchases.download', ['purchase' => $purchase]) }}"/>
                                        @else
                                            <x-table.icon-trailer class="px-0.5" :trailer="false"/>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
                <div class="mt-4">
                    {{ $purchases->links() }}
                </div>
            @else
                <div class="flex justify-center font-bold">No Purchases found</div>
            @endif

        </div>
    </div>
@endsection

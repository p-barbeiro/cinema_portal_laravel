@extends('layouts.main')

@section('header-title', 'Customers')

@section('main')
    <div class="flex justify-center">
        <div class="my-4 p-6 bg-white w-full dark:bg-gray-900 overflow-hidden
                    shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">

            @if($purchases->count() > 0)
                <div class="font-base text-sm text-gray-700 dark:text-gray-300">

                    <table class="table-auto border-collapse w-full">
                        <thead>
                        <th class="text-left">Purchase Date</th>
                        <th class="text-left">Tickets</th>
                        <th class="text-left">Total Price</th>
                        </thead>
                        <tbody>
                        @foreach ($purchases as $purchase)
                            <tr class="border-b border-b-gray-400 dark:border-b-gray-500 hover:bg-gray-50 dark:hover:bg-gray-800">
                                <td class="px-2 py-2 text-left">
                                    {{ date('d/m/y', strtotime($purchase->date)) }}
                                </td>
                                <td class="px-2 py-2 text-left">
                                    {{ $purchase->tickets->count() }}
                                </td>
                                <td class="px-2 py-2 text-left">
                                    {{ $purchase->total_price }} €
                                </td>
                                <td class="px-2 py-2 w-10">
                                    <x-table.icon-show class="px-0.5"
                                                       href="{{ route('purchases.show', ['purchase' => $purchase]) }}"/>

                                </td>
                                <td class="px-2 py-2 w-10">

                                    @if($purchase->receipt_pdf_filename)
                                        <x-table.icon-download class="px-0.5" text=""
                                                           href="{{ route('purchases.download', ['purchase' => $purchase]) }}"/>
                                    @endif
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

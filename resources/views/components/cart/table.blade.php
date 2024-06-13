<div {{ $attributes }}>
    <div class="flex flex-col">
        @foreach ($cart->groupBy(['theater', 'date', 'start_time']) as $theater => $ticketsByTheater)
            <div class="mt-1"></div>
            <div class="border-x border-t border-gray-300 dark:border-gray-700">
                <div
                    class="px-2 py-2 font-bold border-b border-gray-300 bg-gray-200 dark:bg-gray-800 dark:border-gray-700">
                    Theater: {{ $theater }}
                </div>
                @foreach($ticketsByTheater as $date => $ticketsByDate)
                    <div class="flex flex-col border-b border-gray-300 dark:border-gray-700">
                        <div
                            class="px-2 py-2 font-bold border-b border-gray-300 dark:border-gray-700 bg-gray-200 dark:bg-gray-800">{{ date('l, F j', strtotime($date)) }}</div>
                        @foreach($ticketsByDate as $session => $ticketsBySession)
                            <div class="dark:border-b-gray-700">
                                <div class="flex flex-wrap px-2 py-2">
                                    @foreach($ticketsBySession as $ticket)
                                        <div
                                            class="border border-gray-100 dark:border-gray-600 px-2 py-1 w-full flex flex-row items-center justify-end my-0.5">
                                            <span class="grow text-left">Movie: {{ $ticket['movie'] }}</span>
                                            <span
                                                class="mx-2 hidden sm:contents text-gray-200 dark:text-gray-400">|</span>
                                            <span
                                                class="mx-5 text-center w-24">Hour: <b>{{ date('H:i', strtotime($session)) }}</b></span>
                                            <span
                                                class="mx-2 hidden sm:contents text-gray-200 dark:text-gray-400">|</span>
                                            <span
                                                class="mx-5 text-center w-24">Seat: {{ $ticket['row'] }}{{ $ticket['seat_number'] }}</span>
                                            <span
                                                class="mx-2 hidden sm:contents text-gray-200 dark:text-gray-400">|</span>
                                            @php
                                                $customerPrice = number_format($ticket['price']-\App\Models\Configuration::first()->registered_customer_ticket_discount,2);
                                                $guestPrice = number_format($ticket['price'],2);
                                            @endphp
                                            <span class="mx-5 text-center w-24 hidden sm:inline">
                                                Price: {{auth()->user()?$customerPrice:$guestPrice}}€</span>
                                            <span
                                                class="mx-2 hidden sm:contents text-gray-200 dark:text-gray-400">|</span>
                                            <x-table.icon-minus
                                                class="px-0.5 w-10 flex flex-row justify-center items-center"
                                                method="delete"
                                                value="{{ $ticket['seat_id'] }}"
                                                action="{{ route('cart.remove', ['screening' => $ticket['id']]) }}"
                                            />
                                            <x-table.icon-show class="px-0.5"
                                                               href="{{ route('screenings.show', ['screening' => $ticket['id']]) }}"/>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        @endforeach
        <div class="mt-5 px-2 py-2 border-b border-gray-400 dark:border-gray-500 flex flex-row justify-between">
            <div class="font-bold">
                Total:
            </div>
            <div>
                {{ number_format($cart->count()* (auth()->user()?$customerPrice:$guestPrice),2)  }} €
            </div>
        </div>
    </div>
</div>

<div {{ $attributes->merge(['class' => 'hover:text-gray-900']) }}>
    <a href="{{ $href }}">
        @switch($version)
            @case(1)
                <svg class="hover:stroke-2 w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke-width="1" stroke="currentColor">
                            <path
                                d="M9.00004 5H17C17.5523 5 18 5.44772 18 6V19C18 19.5523 17.5523 20 17 20H7.00004C6.44776 20 6.00004 19.5523 6.00004 19V11M9.00004 5L9 9C9 10.1046 8.10457 11 7 11C5.89543 11 5 10.1046 5 9V5M9.00004 5C9.00004 4.44772 8.55228 4 8 4C7.44772 4 7 4.44772 7 5V9M11 9H15M10 12H15M9.00004 15H15"
                                stroke="#464455" stroke-linecap="round" stroke-linejoin="round"></path>
                        </g>
                    </svg>
                </svg>
                @break
            @case(2)
                <svg class="hover:stroke-2 w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke-width="1" stroke="currentColor">
                    <path
                        d="M13.1667 5H6C5.44772 5 5 5.44772 5 6V18C5 18.5523 5.44772 19 6 19H18C18.5523 19 19 18.5523 19 18V10.8333M15.5 5H19M19 5V8.5M19 5L9.66667 14.3333"
                        stroke="#464455" stroke-linecap="round" stroke-linejoin="round"></path>
                    </g>
                </svg>
                @break
        @endswitch
    </a>
</div>

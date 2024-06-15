<div {{ $attributes->merge(['class' => 'hover:text-gray-900']) }}>
    @if($trailer)
        <a href="{{ $href }}">
            <svg class="hover:stroke-2 w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                 stroke-width="1" stroke="currentColor">
                    <path
                        d="M10 9H8C6.34315 9 5 10.3431 5 12C5 13.6569 6.34315 15 8 15H10M14 9H16C17.6569 9 19 10.3431 19 12C19 13.6569 17.6569 15 16 15H14M8 12H16"
                        stroke="#464455" stroke-linecap="round" stroke-linejoin="round"></path>
                </g>
            </svg>
        </a>
    @else
        <svg class="hover:stroke-2 w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
             stroke-width="1" stroke="currentColor">
            <path
                d="M10 9H8C6.34315 9 5 10.3431 5 12C5 13.6569 6.34315 15 8 15H9M9 15L12 12M9 15L5 19M14 9H15M15 9L19 5M15 9L12 12M14 15H16C17.6569 15 19 13.6569 19 12C19 11.1716 18.6642 10.4216 18.1213 9.87868M8 12H12M15 12H16"
                stroke="#464455" stroke-linecap="round" stroke-linejoin="round"></path>
            </g>
        </svg>
    @endif
</div>

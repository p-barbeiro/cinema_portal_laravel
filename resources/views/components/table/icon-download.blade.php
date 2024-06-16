<div {{ $attributes->merge(['class' => 'hover:text-gray-900 dark:hover:text-red-900']) }}>
    @if($href)
    <a href="{{ $href }}" class="inline-flex">
        <div class="me-2">
            {{$text}}
        </div>
        <svg class="hover:stroke-2 w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M8.5 3.5H6.498a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l.002-8l-4-4" />
                    <path d="m13.5 10.586l-3 2.914l-3-2.914m3-8.086v11" />
                </g>
            </svg>
    </a>
    @else
        <svg class="hover:stroke-2 w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" transform="translate(2 2)">
                    <circle cx="8.5" cy="8.5" r="8" />
                    <path d="M14 3L3 14" />
                </g>
            </svg>
    @endif
</div>

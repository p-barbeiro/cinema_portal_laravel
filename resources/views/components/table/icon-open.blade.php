<div {{ $attributes->merge(['class' => 'hover:text-gray-900']) }}>
    <a href="{{ $href }}">
        @if($version==1)
            <svg class="hover:stroke-2 w-6 h-6 hover:stroke-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16.5 15.5v-7l-5-5h-5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2m-10-5h5m-5 2h7m-7 2h3"/>
                    <path d="M11.5 3.5v3a2 2 0 0 0 2 2h3"/>
                </g>
            </svg>
        @else
            <svg class="hover:stroke-2 w-6 h-6 hover:stroke-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M18.5 8.5v-5h-5m5 0l-7 7m-1-7h-5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2v-4"/>
            </svg>
        @endif
    </a>
</div>

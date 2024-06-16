<div {{ $attributes->merge(['class' => 'hover:text-gray-900']) }}>
    <form method="POST" action="{{ $action }}"  class="w-6 h-6">
        @csrf
        @if(strtoupper($method) != 'POST')
            @method(strtoupper($method))
        @endif
        <input type="hidden" name="remove" value="{{$value}}">
        <button type="submit" name="minus" class="w-6 h-6">
            @if($blocked===1)
                <svg class="hover:stroke-2 w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <g fill="none" fill-rule="evenodd" transform="translate(4 1)">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="m2.5 8.5l-.006-1.995C2.487 2.502 3.822.5 6.5.5s4.011 2.002 4 6.005V8.5m-8 0h8.023a2 2 0 0 1 1.994 1.85l.006.156l-.017 6a2 2 0 0 1-2 1.994H2.5a2 2 0 0 1-2-2v-6a2 2 0 0 1 2-2"/>
                        <circle cx="6.5" cy="13.5" r="1.5" fill="none"/>
                    </g>
                </svg>
            @else
                <svg class="hover:stroke-2 w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                    <g fill="none" fill-rule="evenodd" transform="translate(4 1)">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                              d="m2.5 8.5l-.006-1.995C2.487 2.502 3.822.5 6.5.5c2.191 0 3.61 1.32 4 4m-8 4h8.023a2 2 0 0 1 1.994 1.85l.006.156l-.017 6a2 2 0 0 1-2 1.994H2.5a2 2 0 0 1-2-2v-6a2 2 0 0 1 2-2"/>
                        <circle cx="6.5" cy="13.5" r="1.5" fill="none"/>
                    </g>
                </svg>
            @endif
        </button>
    </form>
</div>

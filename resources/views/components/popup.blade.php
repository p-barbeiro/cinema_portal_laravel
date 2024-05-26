<div x-data="{ 'showModal': false }" @keydown.escape="showModal = false">

    <button class="italic text-gray-500 hover:font-semibold" type="button"
            @click="showModal = true;$refs.video.src = '{{$trailerURL}}';">{{$text}}
    </button>
    <!-- Modal -->
    <div class="fixed inset-0 z-30 flex items-center justify-center overflow-auto bg-black md:bg-opacity-90 bg-opacity-100"
        x-show="showModal">
        <!-- Modal inner -->
        <div
            class="w-auto mx-auto text-left bg-white rounded shadow-lg bg-opacity-0 md:max-w-5xl"
            @click.away="showModal = false;$refs.video.src = ''"
            x-transition:enter="motion-safe:ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100">
            <div class="flex justify-end">
                <!-- Close button -->
                <button type="button" class="z-50 cursor-pointer mb-2"
                        @click="showModal = false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <iframe x-ref="video" width="640" height="360"
                    src=''
                    allowfullscreen></iframe>
        </div>
    </div>
</div>

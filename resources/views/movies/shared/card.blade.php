<div>
    <figure
        class="h-auto md:min-h-96 flex flex-col md:flex-row border border-gray-200 shadow rounded-none sm:rounded-xl bg-white dark:bg-gray-900 dark:border-gray-700 my-4 p-8 md:p-0">

        <a class="h-auto md:min-h-96 md:min-w-72 md:max-w-64 mx-auto md:m-0"
           href="{{ route('movies.show', ['movie' => $movie]) }}">
            <img class="h-full object-center aspect-auto p-2 mx-auto rounded-xl" src="{{ $movie->getPoster() }}">
        </a>

        <div class="h-auto w-full p-10 text-center md:min-h-96 md:text-left space-y-1 flex flex-col">
            <a class="text-2xl font-bold text-gray-800 dark:text-gray-200 leading-tight"
               href="{{ route('movies.show', ['movie' => $movie]) }}">
                {{ $movie->title }}
            </a>
            <hr>

            <figcaption class="font-medium">
                <div
                    class="flex justify-center md:justify-start font-base text-base space-x-6 text-gray-700 dark:text-gray-300 md:mb-5">
                    <div>Year: {{ $movie->year }} </div>
                    <div>Genre: {{ $movie->genre->name }} </div>
                    @if($movie->trailer_url)
                        <div x-data="{ 'showModal': false }" @keydown.escape="showModal = false">

                            <button class="italic text-gray-500 hover:font-semibold" type="button"
                                    @click="showModal = true">Watch trailer
                            </button>
                            <!-- Modal -->
                            <div
                                class="fixed inset-0 z-30 flex items-center justify-center overflow-auto bg-black md:bg-opacity-90 bg-opacity-100"
                                x-show="showModal">
                                <!-- Modal inner -->
                                <div
                                    class="w-auto mx-auto text-left bg-white rounded shadow-lg bg-opacity-0 md:max-w-5xl"
                                    @click.away="showModal = false"
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
                                    <iframe width="640" height="360"
                                            src="{{$movie->getTrailerEmbedUrl()}}"
                                            allowfullscreen></iframe>
                                </div>
                            </div>
                        </div>
                        {{--                        <a class="italic text-gray-500" href="{{ $movie->trailer_url }}">Watch trailer</a>--}}
                    @endif
                </div>
            </figcaption>

            <p class="pt-4 font-light text-gray-700 dark:text-gray-300 overflow-y-auto bg-gray-50 rounded-md md:p-3 md:min-h-48 md:dark:bg-gray-800 dark:bg-gray-900">
                {{ $movie->synopsis }}
            </p>

            <div class="flex md:justify-end pt-5">
                <x-button element="a" type="light" text="See more" class="ms-4"
                          href="{{ route('movies.show', ['movie' => $movie]) }}"/>
            </div>
        </div>

    </figure>
</div>

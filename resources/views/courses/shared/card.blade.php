<div>
    <figure class="h-auto md:min-h-96 flex flex-col md:flex-row
                    border border-gray-200 shadow
                    rounded-none sm:rounded-xl
                    bg-white dark:bg-gray-900 dark:border-gray-700
                    my-4 p-8 md:p-0">
        <a class="h-auto md:min-h-96 md:min-w-72 md:max-w-64 mx-auto md:m-0"
           href="{{ route('movies.show', ['movie' => $movie]) }}">
            <img class="h-full object-center aspect-auto p-2 mx-auto rounded-xl"
                 src="{{ $movie->getPoster() }}">
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
                    <a class="italic text-gray-500" href="{{ $movie->trailer_url }}">Watch trailer</a>
                </div>
            </figcaption>

            <p class="pt-4 font-light text-gray-700 dark:text-gray-300 overflow-y-auto bg-gray-50 rounded-md md:p-3 md:min-h-48 md:dark:bg-gray-800 dark:bg-gray-900">
                {{ $movie->synopsis }}
            </p>

            <div class="flex md:justify-end pt-5">
                <x-button element="a" type="light" text="See more" class="ms-4" href="{{ route('movies.show', ['movie' => $movie]) }}"/>
            </div>
        </div>

    </figure>
</div>

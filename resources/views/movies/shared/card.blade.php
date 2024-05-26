<div>
    <figure
        class="h-auto md:min-h-96 flex flex-col items-center md:flex-row border border-gray-200 shadow rounded-none sm:rounded-xl bg-white dark:bg-gray-900 dark:border-gray-700 my-4 p-8 md:p-0">

        <div class="h-auto w-full p-5 text-center md:min-h-96 md:text-left space-y-1 flex flex-col">
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
                </div>
            </figcaption>

            <p class="pt-4 font-light text-gray-700 dark:text-gray-300 overflow-y-auto bg-gray-50 rounded md:p-3 md:dark:bg-gray-800 dark:bg-gray-900">
                {{ $movie->synopsis }}
            </p>

            <p class="font-base text-base space-x-6 text-gray-700 dark:text-gray-300 md:mb-5">
                <x-screenings.table :screenings="$movie->getScreenings()"/>
            </p>
        </div>

        <div class="flex flex-col h-auto p-5 ps-0 md:min-h-96 md:min-w-80 md:max-w-64 mx-auto md:m-0">
            <a class=""
               href="{{ route('movies.show', ['movie' => $movie]) }}">
                <img class="object-center aspect-auto mx-auto rounded-md" src="{{ $movie->getPoster() }}">
            </a>
            @if($movie->trailer_url)
                <iframe class="mt-5 rounded" src="{{ $movie->getTrailerEmbedUrl() }}" allowfullscreen></iframe>
            @endif
        </div>

    </figure>
</div>

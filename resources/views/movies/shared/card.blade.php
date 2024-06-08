<div>
    <figure
        class="flex flex-col lg:flex-row-reverse h-auto border border-gray-200 shadow rounded-none sm:rounded-xl bg-white dark:bg-gray-900 dark:border-gray-700 my-5 p-5 md:p-0">

        <div class="place-content-center h-auto p-5 md:p-5 md:ps-0 mx-auto md:m-0">
            <img class="object-center aspect-auto mx-auto rounded-md md:min-h-96 md:min-w-80 md:max-w-64"
                 src="{{ $movie->getPoster() }}">
        </div>

        <div class="w-full p-5 text-center md:min-h-96 md:text-left space-y-1 flex flex-col">

            <div class="flex flex-row justify-between">
                <span
                    class="text-2xl font-bold text-gray-800 dark:text-gray-200 leading-tight">{{ $movie->title }}</span>
                <div class="flex flex-row">
                    @can('view', $movie)
                        <x-table.icon-show class="px-0.5"
                                           href="{{ route('movies.show', ['movie' => $movie]) }}"/>
                    @endcan
                    @can('update', $movie)
                        <x-table.icon-edit class="px-0.5"
                                           href="{{ route('movies.edit', ['movie' => $movie]) }}"/>
                    @endcan
                </div>
            </div>
            <hr>
            <figcaption class="font-medium">
                <div
                    class="flex justify-center md:justify-start font-base text-base space-x-6 text-gray-700 dark:text-gray-300 md:mb-5">
                    <div>Year: {{ $movie->year }} </div>
                    <div>Genre: {{ $movie->genre?->name?? 'Unknown Genre'}} </div>
                    @if($movie->trailer_url)
                        <a href="{{ $movie->trailer_url }}" class="text-blue-500 font-bold">Watch
                            Trailer</a>
                    @endif
                </div>
            </figcaption>

            <p class="p-2 font-light text-gray-700 dark:text-gray-300 overflow-y-auto bg-gray-50 rounded md:p-3 dark:bg-gray-800 text-justify">
                {{ $movie->synopsis }}
            </p>
            <p class="font-base text-base space-x-6 text-gray-700 dark:text-gray-300 md:mb-5">
                <x-screenings.table :screenings="$movie->getScreenings()"/>
            </p>

        </div>

    </figure>
</div>

<div {{ $attributes }}>
    <table class="table-auto border-collapse w-full">
        <thead>
        <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
            <th class="px-2 py-2 text-center lg:table-cell">Poster</th>
            <th class="px-2 py-2 text-center">Name</th>
            <th class="px-2 py-2 text-center hidden sm:table-cell">Genre</th>
            <th class="px-2 py-2 text-center hidden sm:table-cell">Year</th>
            <th class="hidden sm:table-cell">Trailer</th>
            @if($showView)
                <th class="hidden sm:table-cell"></th>
            @endif
            @if($showEdit)
                <th class="hidden sm:table-cell"></th>
            @endif
            @if($showDelete)
                <th class="hidden sm:table-cell"></th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach ($movies as $movie)
            <tr class="border-b border-b-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 dark:border-b-gray-500">

                <td class="px-2 py-2 w-32">
                    <img class="object-center aspect-auto w-32 h-40 rounded" src="{{ $movie->getPoster() }}" alt="{{ $movie->title }}">
                </td>

                <td class="px-2 py-2 text-left">
                    <div class="text-lg">
                        <a href="{{ route('movies.show', ['movie' => $movie]) }}" class="hover:font-bold hover:underline">
                            {{ $movie->title }}
                        </a>
                    </div>
                    <br>
                    <div>
                        {{$movie->synopsis}}
                    </div>
                </td>

                <td class="px-2 py-2 text-center hidden sm:table-cell">
                    {{ $movie->genre?->name?? 'Unknown' }}
                </td>

                <td class="px-2 py-2 text-center hidden sm:table-cell">
                    {{ $movie->year }}
                </td>


                <td class="px-2 py-2 text-center align-middle hidden sm:table-cell">
                    <div class="flex justify-center items-center h-full">
                        @if($movie?->trailer_url)
                            <x-table.icon-trailer href="{{ $movie?->trailer_url }}"/>
                        @else
                            <x-table.icon-trailer :trailer="false"/>
                        @endif
                    </div>
                </td>

                @if($showView)
                    @can('view', $movie)
                        <td class="px-2 py-2 text-center align-middle hidden sm:table-cell">
                            <div class="flex justify-center items-center h-full">
                                <x-table.icon-show href="{{ route('movies.show', ['movie' => $movie]) }}"/>
                            </div>
                        </td>
                    @else
                        <td class="hidden sm:table-cell"></td>
                    @endcan
                @endif

                @if($showEdit)
                    @can('update', $movie)
                        <td class="px-2 py-2 text-center align-middle hidden sm:table-cell">
                            <div class="flex justify-center items-center h-full">
                                <x-table.icon-edit href="{{ route('movies.edit', ['movie' => $movie]) }}"/>
                            </div>
                        </td>
                    @else
                        <td class="hidden sm:table-cell"></td>
                    @endcan
                @endif

                @if($showDelete)
                    @can('delete', $movie)
                        <td class="px-2 py-2 text-center align-middle hidden sm:table-cell">
                            <div class="flex justify-center items-center h-full">
                                <x-table.icon-delete action="{{ route('movies.destroy', ['movie' => $movie]) }}"/>
                            </div>
                        </td>
                    @else
                        <td class="hidden sm:table-cell"></td>
                    @endcan
                @endif

            </tr>
        @endforeach
        </tbody>
    </table>
</div>

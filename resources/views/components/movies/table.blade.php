<div {{ $attributes }}>
    <table class="table-auto border-collapse w-full">
        <thead>
        <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
            <th class="px-2 py-2 text-center lg:table-cell">Poster</th>
            <th class="px-2 py-2 text-center">Name</th>
            <th class="px-2 py-2 text-center">Genre</th>
            <th class="px-2 py-2 text-center hidden sm:table-cell">Year</th>
            {{--            trailer--}}
            <th></th>
            @if($showView)
                <th></th>
            @endif
            @if($showEdit)
                <th></th>
            @endif
            @if($showDelete)
                <th></th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach ($movies as $movie)
            <tr class="border-b border-b-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 dark:border-b-gray-500">
                <td class="px-2 py-2 w-32">
                    <img class="object-center aspect-auto w-32 h-40 rounded" src="{{ $movie->getPoster() }}"
                         alt="{{ $movie->title }}">
                </td>
                <td class="px-2 py-2 text-left">
                    <div class="font-bold">
                        {{ $movie->title }}
                    </div>
                    <br>
                    <div>
                        {{$movie->synopsis}}
                    </div>
                </td>
                <td class="px-2 py-2 text-left">{{ $movie->genre->name }}</td>
                <td class="px-2 py-2 text-right hidden sm:table-cell">{{ $movie->year }}</td>
                <td>
                    @if($movie?->trailer_url)
                        <x-table.icon-trailer class="ps-3 px-0.5" href="{{ $movie?->trailer_url }}"/>
                    @else
                        <x-table.icon-trailer class="ps-3 px-0.5" :trailer="false" />
                    @endif
                </td>
                @if($showView)
                    @can('view', $movie)
                        <td>
                            <x-table.icon-show class="ps-3 px-0.5"
                                               href="{{ route('movies.show', ['movie' => $movie]) }}"/>
                        </td>
                    @else
                        <td></td>
                    @endcan
                @endif
                @if($showEdit)
                    @can('update', $movie)
                        <td>
                            <x-table.icon-edit class="px-0.5"
                                               href="{{ route('movies.edit', ['movie' => $movie]) }}"/>
                        </td>
                    @else
                        <td></td>
                    @endcan
                @endif
                @if($showDelete)
                    @can('delete', $movie)
                        <td>
                            <x-table.icon-delete class="px-0.5"
                                                 action="{{ route('movies.destroy', ['movie' => $movie]) }}"/>
                        </td>
                    @else
                        <td></td>
                    @endcan
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

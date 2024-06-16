<div {{ $attributes }}>
    <table class="table-auto border-collapse w-full">
        <thead>
        <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
            <th class="px-2 py-2 text-left lg:table-cell">Code</th>
            <th class="px-2 py-2 text-left lg:table-cell">Genre</th>
            @if($showEdit)
                <th></th>
            @endif
            @if($showDelete)
                <th></th>
            @endif
        </tr>
        </thead>

        <tbody>
        @foreach ($genres as $genre)
            <tr class="border-b border-b-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 dark:border-b-gray-500">

                <td class="px-2 py-2 text-left lg:table-cell">{{ $genre->code }}</td>
                <td class="px-2 py-2 text-left lg:table-cell">{{ $genre->name }}</td>

                @if($showEdit)
                    @can('update', $genre)
                        <td class="p-2 text-center align-middle">
                            <div class="flex justify-center items-center h-full">
                            <x-table.icon-edit href="{{ route('genres.edit', ['genre' => $genre]) }}"/>
                            </div>
                        </td>
                    @else
                        <td></td>
                    @endcan
                @endif

                @if($showDelete)
                    @can('delete', $genre)
                        <td class="p-2 text-center align-middle">
                            <div class="flex justify-center items-center h-full">
                            <x-table.icon-delete action="{{ route('genres.destroy', ['genre' => $genre]) }}"/>
                            </div>
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

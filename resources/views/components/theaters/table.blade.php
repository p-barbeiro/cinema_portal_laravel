<div {{ $attributes }}>
    <table class="table-auto border-collapse w-full">
        <thead>
        <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
            <th class="px-2 py-2 text-center lg:table-cell">Photo</th>
            <th class="px-2 py-2 text-left w-1/2 lg:table-cell">Theater</th>
            <th class="px-2 py-2 text-center lg:table-cell">Capacity</th>
            <th class="px-2 py-2 text-center hidden lg:table-cell">Rows</th>
            <th class="px-2 py-2 text-center max-w-30 hidden lg:table-cell">Columns</th>
            <th class="px-2 py-2 text-center">Edit</th>
            <th class="px-2 py-2 text-center">Delete</th>
        </tr>
        </thead>

        <tbody>
        @foreach ($theaters as $theater)
            <tr class="border-b border-b-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 dark:border-b-gray-500">

                <td class="px-2 py-2 text-left w-24 h-24">
                    <img class="object-center object-cover w-full h-full aspect-square rounded-full" src="{{ $theater->getPhoto() }}">
                </td>

                <td class="px-2 py-2 text-left lg:table-cell">{{ $theater->name }}</td>
                <td class="px-2 py-2 text-center lg:table-cell">{{ $theater->seats->count() }}</td>
                <td class="px-2 py-2 text-center hidden lg:table-cell">{{ $theater->seats->pluck('row')->unique()->count() }}</td>
                <td class="px-2 py-2 text-center hidden lg:table-cell">{{ $theater->seats->pluck('seat_number')->unique()->count() }}</td>

                @if($showEdit)
                    @can('update', $theater)
                        <td class="p-2 text-center align-middle">
                            <div class="flex justify-center items-center h-full">
                                <x-table.icon-edit class="px-0.5" href="{{ route('theaters.edit', ['theater' => $theater]) }}"/>
                            </div>
                        </td>
                    @else
                        <td></td>
                    @endcan
                @endif

                @if($showDelete)
                    @can('delete', $theater)
                        <td class="p-2 text-center align-middle">
                            <div class="flex justify-center items-center h-full">
                                <x-table.icon-delete class="px-0.5" action="{{ route('theaters.destroy', ['theater' => $theater]) }}"/>
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

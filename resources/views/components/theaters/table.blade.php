<div {{ $attributes }}>
    <table class="table-auto border-collapse w-full">
        <thead>
        <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
            <th class="px-2 py-2 text-center lg:table-cell">Photo</th>
            <th class="px-2 py-2 text-left lg:table-cell">Theater</th>
            <th class="px-2 py-2 text-left lg:table-cell">Capacity</th>
            @if($showEdit)
                <th></th>
            @endif
            @if($showDelete)
                <th></th>
            @endif
        </tr>
        </thead>

        <tbody>
        @foreach ($theaters as $theater)
            <tr class="border-b border-b-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 dark:border-b-gray-500">
                <td class="px-2 py-2 w-32">
                    <img class="object-center aspect-auto w-24 h-24 rounded-full" src="{{ $theater->getPhoto() }}"
                         alt="{{ $theater->id }}">
                </td>
                <td class="px-2 py-2 text-left lg:table-cell">{{ $theater->name }}</td>
                <td class="px-2 py-2 text-left lg:table-cell">{{ $theater->seats->count() }}</td>

                @if($showDelete)
                    @can('delete', $theater)
                        <td>
                            <x-table.icon-delete class="px-0.5"
                                                 action="{{ route('theaters.destroy', ['theater' => $theater]) }}"/>
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

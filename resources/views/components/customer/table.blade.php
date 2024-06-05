<div {{ $attributes }}>
    <table class="table-auto border-collapse w-full">
        <thead>
        <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
            <th class="px-2 py-2 text-center">Photo</th>
            <th class="px-2 py-2 text-left">Name</th>
            <th class="px-2 py-2 text-left hidden md:table-cell">Email</th>
            <th class="px-2 py-2 text-center hidden md:table-cell">NIF</th>
            <th class="px-2 py-2 text-center hidden md:table-cell">Payment Type</th>
            @if($showEdit)
                <th></th>
            @endif
            @if($showDelete)
                <th></th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach ($customers as $customer)
            <tr class="border-b border-b-gray-400 dark:border-b-gray-500 hover:bg-gray-50 dark:hover:bg-gray-800">
                <td class="px-2 py-2 text-left w-24 h-24 rounded-full">
                    <img class="rounded-full" src="{{ $customer->user->getPhotoFullUrlAttribute()}}">
                </td>

                <td class="px-2 py-2 text-left">{{ $customer->user->name ?? 'No Name' }}</td>

                <td class="px-2 py-2 text-left underline underline-offset-2 hidden md:table-cell">
                    <a href="mailto:{{ $customer->user->email ?? '#' }}">
                        {{ $customer->user->email ?? 'No email' }}
                    </a>
                </td>

                <td class="px-2 py-2 text-center hidden md:table-cell">{{ $customer->nif ?? 'Without NIF' }}</td>

                <td class="px-2 py-2 text-center hidden md:table-cell">{{ $customer->payment_type ?? 'Unknown Payment Type' }}</td>

                @if($showView)
                    @can('view', $customer)
                        <td>
                            <x-table.icon-show class="ps-3 px-0.5"
                                               href="{{ route('customers.show', ['customer' => $customer]) }}"/>
                        </td>
                    @else
                        <td></td>
                    @endcan
                @endif
                @if($showEdit)
                    @can('update', $customer)
                        <td>
                            <x-table.icon-edit class="px-0.5"
                                               href="{{ route('customers.edit', ['customer' => $customer]) }}"/>
                        </td>
                    @else
                        <td></td>
                    @endcan
                @endif
                @if($showDelete)
                    @can('delete', $customer)
                        <td>
                            <x-table.icon-delete class="px-0.5"
                                                 action="{{ route('customers.destroy', ['customer' => $customer]) }}"/>
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

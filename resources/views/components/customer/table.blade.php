<div {{ $attributes }}>
    <table class="table-auto border-collapse w-full">
        <thead>
        <tr class="border-b-2 border-b-gray-400 dark:border-b-gray-500 bg-gray-100 dark:bg-gray-800">
            <th class="px-2 py-2 text-center">Photo</th>
            <th class="px-2 py-2 text-left">Name</th>
            <th class="px-2 py-2 text-left hidden md:table-cell">Email</th>
            <th class="px-2 py-2 text-center hidden md:table-cell">NIF</th>
            <th class="px-2 py-2 text-center hidden md:table-cell">Payment Type</th>
            <th class="px-2 py-2 text-center">Purchases</th>
            <th class="px-2 py-2 text-center">Status</th>
            <th class="px-2 py-2 text-center">Delete</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($customers as $customer)
            @if($customer->user->blocked)
            <tr class="border-b border-b-gray-400 dark:border-b-gray-500 hover:bg-gray-50 dark:hover:bg-gray-800 text-red-700">
            @else
            <tr class="border-b border-b-gray-400 dark:border-b-gray-500 hover:bg-gray-50 dark:hover:bg-gray-800">
            @endif
                <td class="px-2 py-2 text-left w-24 h-24">
                    <img class="object-center object-cover w-full h-full aspect-square rounded-full" src="{{ $customer->user->getPhotoFullUrlAttribute()}}">
                </td>

                <td class="px-2 py-2 text-left">{{ $customer->user->name ?? 'No Name' }}</td>

                <td class="px-2 py-2 text-left underline underline-offset-2 hidden md:table-cell">
                    <a href="mailto:{{ $customer->user->email ?? '#' }}">
                        {{ $customer->user->email ?? 'No email' }}
                    </a>
                </td>

                <td class="px-2 py-2 text-center hidden md:table-cell">{{ $customer->nif ?? 'None' }}</td>

                <td class="px-2 py-2 text-center hidden md:table-cell">{{ $customer->payment_type ?? 'None' }}</td>

                <td class="px-2 py-2 h-full text-center align-middle">
                    <div class="flex justify-center items-center h-full">
                        <x-table.icon-open href="{{ route('purchases.index', ['customer' => $customer]) }}"/>
                    </div>
                </td>

                <td class="px-2 py-2 h-full text-center align-middle">
                    <div class="flex justify-center items-center h-full">
                        <x-table.icon-blocked
                                :blocked="$customer->user->blocked"
                                action="{{ route('customers.block', ['customer' => $customer]) }} "
                        />
                    </div>
                </td>

                <td class="px-2 py-2 text-center align-middle">
                    <div class="flex justify-center items-center h-full">
                        <x-table.icon-delete class="px-0.5" action="{{ route('customers.destroy', ['customer' => $customer]) }}"/>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

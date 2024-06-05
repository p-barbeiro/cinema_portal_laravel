@extends('layouts.main')

@section('header-title', 'Customers')

@section('main')
    <div class="flex justify-center">
        <div class="my-4 p-6 bg-white w-full dark:bg-gray-900 overflow-hidden
                    shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">
            <x-customer.filter-card
                :filterAction="route('customers.index')"
                :resetUrl="route('customers.index')"
                :search="old('search', $filterByName)"
                class="mb-6"
            />

            @if($customers->count() > 0)
                <div class="font-base text-sm text-gray-700 dark:text-gray-300">
                    <x-customer.table :customers="$customers"
                                      :showView="false"
                                      :showEdit="false"
                                      :showDelete="true"
                    />
{{--                    TODO: Block user--}}
                </div>
                <div class="mt-4">
                    {{ $customers->links() }}
                </div>
            @else
                <div class="flex justify-center font-bold">No Customers found</div>
            @endif

        </div>
    </div>
@endsection

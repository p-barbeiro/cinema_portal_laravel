@extends('layouts.main')

@section('header-title', 'Staff')

@section('main')
    <div class="flex justify-center">
        <div class="my-4 p-6 bg-white w-full dark:bg-gray-900 overflow-hidden
                    shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">

            <x-users.filter-card    :filterAction="route('users.index')"
                                    :resetUrl="route('users.index')"
                                    :name="old('name',$filterByName)"
                                    :type="old('type',$filterByType)"
                                    class="mb-6"
            />
            <hr class="dark:border-gray-700">
            @can('create', App\Models\User::class)
                <div class="flex justify-end gap-4 my-4">
                    <x-button
                        href="{{ route('users.create') }}"
                        text="Add new user"
                        type="dark"/>
                </div>
            @endcan

            @if($users->count() > 0)
                <div class="font-base text-sm text-gray-700 dark:text-gray-300">
                    <x-users.table :users="$users" />
                </div>
            <div class="mt-4">
                {{ $users->links() }}
            </div>
            @else
                <div class="flex items-center justify-center font-bold h-72">No Users found</div>
            @endif
        </div>
    </div>
@endsection

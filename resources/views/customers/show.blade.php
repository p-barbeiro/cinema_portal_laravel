@extends('layouts.main')

@section('header-title', 'Customer "' . $customer->user->name . '"')

@section('main')
    <div class="flex flex-col space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
            <div class="max-full">
                <section>

                    <div class="flex flex-wrap justify-end items-center gap-4 mb-4">
                        @can('update', $customer)
                            <x-button
                                href="{{ route('customers.edit', ['customer' => $customer]) }}"
                                text="Edit"
                                type="info"/>
                        @endcan
                    </div>

                    <div>
                        @include('customers.shared.fields', ['mode' => 'show'])
                    </div>

                </section>
            </div>
        </div>
    </div>
    <form class="hidden" id="form_to_delete_photo"
          method="POST" action="{{ route('users.photo.destroy', ['user' => $customer->user]) }}">
        @csrf
        @method('DELETE')
    </form>
@endsection


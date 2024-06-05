@extends('layouts.main')

@section('header-title', 'User "' . $user->name . '"')

@section('main')
    <div class="flex flex-col space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
            <div class="max-full">
                <section>
                    <div class="flex flex-wrap justify-end items-center gap-4 mb-4">
                        @can('update', $user)
                            <x-button
                                href="{{ route('users.edit', ['user' => $user]) }}"
                                text="Edit"
                                type="info"/>
                        @endcan
                        {{--                        @can('delete', $user)--}}
                        {{--                            <form method="POST" action="{{ route('users.destroy', ['user' => $user]) }}">--}}
                        {{--                                @csrf--}}
                        {{--                                @method('DELETE')--}}
                        {{--                                <x-button--}}
                        {{--                                        element="submit"--}}
                        {{--                                        text="Delete"--}}
                        {{--                                        type="danger"/>--}}
                        {{--                            </form>--}}
                        {{--                        @endcan--}}
                    </div>

                    <div>
                        @include('users.shared.fields', ['mode' => 'show'])
                    </div>

                </section>
            </div>
        </div>
    </div>
    <form class="hidden" id="form_to_delete_photo"
          method="POST" action="{{ route('users.photo.destroy', ['user' => $user]) }}">
        @csrf
        @method('DELETE')
    </form>
@endsection


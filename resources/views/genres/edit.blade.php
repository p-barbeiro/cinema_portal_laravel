@extends('layouts.main')

@section('main')
    <div class="flex flex-col space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
            <div class="max-full">
                <section>
                    <div class="flex flex-wrap justify-end items-center gap-4 mb-4">
                        @can('delete', $genre)
                            <form method="POST" action="{{ route('genres.destroy', ['genre' => $genre]) }}">
                                @csrf
                                @method('DELETE')
                                <x-button
                                    element="submit"
                                    text="Delete"
                                    type="secondary"/>
                            </form>
                        @endcan
                    </div>

                    <hr>

                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mt-5">
                            Edit genre "{{ $genre->name }}"
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-300  mb-6">
                            Click on "Save" button to store the information.
                        </p>
                    </header>

                    <form method="POST" action="{{ route('genres.update', ['genre' => $genre]) }}"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mt-6 space-y-4">
                            <x-field.input name="name"
                                           label="Genre"
                                           class="grow"
                                           value="{{ $genre->name }}"/>
                        </div>
                        <div class="flex mt-6">
                            <x-button element="submit" type="dark" text="Save" class="uppercase"/>
                            <x-button element="a" type="light" text="Cancel" class="uppercase ms-4"
                                      href="{{ route('genres.index') }}"/>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
@endsection


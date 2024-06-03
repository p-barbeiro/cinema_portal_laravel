@extends('layouts.main')

@section('header-title', 'Add new genre')

@section('main')
    <div class="flex flex-col space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
            <div class="max-full">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            Add New Genre
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-300  mb-6">
                            Click on "Save" button to store the information.
                        </p>
                    </header>

                    <form method="POST" action="{{ route('genres.store') }}"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="mt-6 space-y-4">
                            <x-field.input name="code"
                                           label="Genre code"
                                           class="grow"
                                           value="{{ $genre->code }}"/>

                            <x-field.input name="name"
                                           label="Genre"
                                           class="grow"
                                           value="{{ $genre->name }}"/>
                        </div>
                        <div class="flex mt-6">
                            <x-button element="submit" type="dark" text="Save New Genre" class="uppercase"/>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
@endsection

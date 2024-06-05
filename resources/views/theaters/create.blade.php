@extends('layouts.main')

@section('header-title', 'Add new Theater')

@section('main')
    <div class="flex flex-col space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
            <div class="max-full">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            Add New Theater
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-300  mb-6">
                            Click on "Save" button to store the information.
                        </p>
                    </header>

                    <form method="POST" action="{{ route('theaters.store') }}"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="mt-6 space-y-4">
                            <div class="flex md:flex-row flex-col space-x-8">
                                <div class="grow mt-6 space-y-4">
                                    <x-field.input name="name" label="Name"
                                                   value="{{ old('name', $theater->name)  }}"
                                                   required="true"/>
                                    <x-field.input name="rows" label="Rows"
                                                   required="true"
                                                   value=""/>
                                    <x-field.input name="cols" label="Columns"
                                                   required="true"
                                                   value=""/>
                                </div>
                                <div>
                                    <x-field.image
                                        name="photo_filename"
                                        label="Theather Photo"
                                        width="md"
                                        deleteTitle="Remove Poster"
                                        :deleteAllow="boolval($theater->photo_filename)"
                                        deleteForm="form_to_delete_image"
                                        :imageUrl="$theater->getPhoto()"/>
                                </div>
                            </div>
                            <div class="flex mt-6">
                                <x-button element="submit" type="dark" text="Save New Theater" class="uppercase"/>
                            </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
@endsection

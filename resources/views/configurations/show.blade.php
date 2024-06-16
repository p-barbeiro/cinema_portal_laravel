@extends('layouts.main')

@section('main')
    <div class="flex flex-col space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
            <div class="max-full">
                <section>
                    <div class="flex flex-wrap justify-between items-center gap-4 mb-4">
                        <div class="font-bold dark:text-white">
                            Configuration Details
                        </div>
                        <x-button
                                href="{{ route('configurations.edit', ['configuration' => $configs]) }}"
                                text="Edit"
                                type="dark"/>
                    </div>
                    <hr class="dark:border-gray-700">
                    <div class="space-y-4 mt-5">
                        @include('configurations.shared.fields', ['mode' => 'show'])
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection

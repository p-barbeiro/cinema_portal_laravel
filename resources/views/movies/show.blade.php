@extends('layouts.main')

@section('header-title', $movie->Title)

@section('main')
<div class="flex flex-col space-y-6">
    <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
        <div class="max-full">
            <section>
                <div class="flex flex-wrap justify-end items-center gap-4 mb-4">
                    @can('update', $movie)
                    <x-button
                        href="{{ route('movies.edit', ['movie' => $movie]) }}"
                        text="Edit"
                        type="dark"/>
                    @endcan
                    @can('delete', $movie)
                    <form method="POST" action="{{ route('movies.destroy', ['movie' => $movie]) }}">
                        @csrf
                        @method('DELETE')
                        <x-button
                            element="submit"
                            text="Delete"
                            type="dark"/>
                    </form>
                    @endcan
                </div>
                <hr>
                <div class="space-y-4 mt-5">
                    @include('movies.shared.fields', ['mode' => 'show'])
                </div>
            </section>
        </div>
    </div>
</div>
@endsection

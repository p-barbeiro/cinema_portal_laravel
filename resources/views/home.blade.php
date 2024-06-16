@extends('layouts.main')

@section('header-title', '')

@section('main')
    <main>
        <div class="max-w-7xl mx-auto py-4 sm:px-6 lg:px-8">
            <div class="my-6 p-8 bg-white dark:bg-gray-900 overflow-hidden shadow-lg sm:rounded-lg text-gray-900 dark:text-gray-50">
                <h3 class="font-extrabold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center">
                    Discover the Magic of Movies at Cinemagic
                </h3>
                <div class="flex justify-center items-center my-8">
                    <a href="{{ route('movies.showcase') }}">
                        <img src="{{ asset('img/cinemagic_banner.png') }}" alt="Cinemagic Banner" class="h-96 w-192 dark:hidden">
                        <img src="{{ asset('img/cinemagic_dark_banner.png') }}" alt="Cinemagic Dark Banner" class="h-96 w-192 hidden dark:block">
                    </a>
                </div>
                <p class="py-3 font-medium text-lg text-gray-700 dark:text-gray-300 text-justify">
                    At Cinemagic, we bring you the latest and greatest movies from around the world. Enjoy a premium viewing experience with state-of-the-art technology, comfortable seating, and a wide selection of snacks and beverages. Whether you're a fan of action, romance, comedy, or drama, we have something for everyone.
                </p>
                <p class="py-3 font-medium text-lg text-gray-700 dark:text-gray-300 text-justify">
                    Our theaters are designed to provide you with an immersive movie experience. From blockbuster hits to indie gems, Cinemagic is dedicated to showcasing a diverse range of films that cater to all tastes. Join us and be part of a community that celebrates the art of cinema.
                </p>
                <p class="py-3 font-medium text-lg text-gray-700 dark:text-gray-300 text-justify">
                    <a href="{{ route('login') }}" class="text-red-600 hover:text-red-800 font-semibold">Sign up</a> for our newsletter to stay updated on the latest releases, special screenings, and <span class="text-red-600 font-semibold">ticket discounts</span>. At Cinemagic, every movie is a magical experience waiting to unfold.
                </p>
            </div>
        </div>
    </main>
@endsection

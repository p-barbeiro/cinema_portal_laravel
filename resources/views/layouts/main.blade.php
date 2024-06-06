<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Cinemagic</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    <!-- Scripts AND CSS Fileds -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
<div class="min-h-[calc(100vh-68.8px)] bg-gray-100 dark:bg-gray-800">

    <!-- Navigation Menu -->
    <nav class="bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800">
        <!-- Navigation Menu Full Container -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Logo + Menu Items + Hamburger -->
            <div class="relative flex flex-col sm:flex-row px-6 sm:px-0 grow justify-between">
                <!-- Logo -->
                <div class="shrink-0 -ms-4 mr-4">
                    <a href="{{ route('home')}}">
                        <div
                            class="h-16 w-40 bg-cover bg-[url('../img/cinemagic.svg')] dark:bg-[url('../img/cinemagic_dark.svg')]"></div>
                    </a>
                </div>

                <!-- Menu Items -->
                <div id="menu-container" class="grow flex flex-col sm:flex-row items-stretch
                    invisible h-0 sm:visible sm:h-auto">

                    <!-- Menu Item: What's On -->
                    <x-menus.menu-item
                        content="What's On"
                        href="{{ route('movies.showcase') }}"
                        selected="{{ Route::currentRouteName() == 'movies.showcase'}}"
                    />

                    <!-- Menu Item: Admin -->
                    <x-menus.submenu
                        selectable="0"
                        uniqueName="submenu_movies"
                        content="Administration">
                        <x-menus.submenu-item
                            content="Theaters"
                            selectable="0"
                            href="{{ route('theaters.index') }}"/>
                        <x-menus.submenu-item
                            content="Movies"
                            selectable="0"
                            href="{{ route('movies.index') }}"
                        />
                        <x-menus.submenu-item
                            content="Genres"
                            selectable="0"
                            href="{{ route('genres.index') }}"/>
                        <x-menus.submenu-item
                            content="Screenings"
                            selectable="0"
                            href="{{ route('screenings.index') }}"/>
                        <hr>
                        <x-menus.submenu-item
                            content="Customers"
                            selectable="0"
                            href="{{ route('customers.index') }}"/>
                        <x-menus.submenu-item
                            content="Staff"
                            selectable="0"
                            href="{{ route('users.index') }}"/>
                        <hr>
                        <x-menus.submenu-item
                            content="Statistics"
                            selectable="0"
                            href="#"/>
                    </x-menus.submenu>

                    <!-- Menu Item: Settings-->
                    <x-menus.menu-item
                        content="Configurations"
                        selectable="1"
                        href="{{ route('configurations.show', ['configuration' => '1']) }}"
                        selected="{{ Route::currentRouteName() == 'configurations.show'}}"
                    />
                    <div class="grow"></div>

                    <!-- Menu Item: Cart -->
                    @if (session('cart'))
                        @can('use-cart')
                            <x-menus.cart
                                :href="route('cart.show')"
                                selectable="1"
                                selected="{{ Route::currentRouteName() == 'cart.show'}}"
                                :total="session('cart')->count()"/>
                        @endcan
                    @endif

                    @auth
                        <x-menus.submenu
                            selectable="0"
                            uniqueName="submenu_user"
                        >
                            <x-slot:content>
                                <div class="pe-1">
                                    <img src="{{ Auth::user()->photoFullUrl}}"
                                         class="w-11 h-11 min-w-11 min-h-11 rounded-full">
                                </div>
                                {{-- ATENÇÃO - ALTERAR FORMULA DE CALCULO DAS LARGURAS MÁXIMAS QUANDO O MENU FOR ALTERADO --}}
                                <div
                                    class="ps-1 sm:max-w-[calc(100vw-39rem)] md:max-w-[calc(100vw-41rem)] lg:max-w-[calc(100vw-46rem)] xl:max-w-[34rem] truncate">
                                    {{ Auth::user()->name }}
                                </div>
                            </x-slot>
                            @auth
                                <hr>
                                <x-menus.submenu-item
                                    content="Profile"
                                    selectable="0"
                                    href="{{route('users.edit', ['user' => Auth::user()])}}"
                                />
                                <x-menus.submenu-item
                                    content="Purchases"
                                    selectable="0"
                                    href="{{ route('customers.purchases') }}"/>
                                <x-menus.submenu-item
                                    content="Change Password"
                                    selectable="0"
                                    href="{{ route('profile.edit.password') }}"/>
                            @endauth
                            <hr>
                            <x-menus.submenu-item
                                content="Log Out"
                                selectable="0"
                                form="form_to_logout_from_menu"/>
                            <form id="form_to_logout_from_menu" method="POST" action="{{ route('logout') }}"
                                  class="hidden">
                                @csrf
                            </form>
                        </x-menus.submenu>
                    @else
                        <!-- Menu Item: Login -->
                        <x-menus.menu-item
                            content="Login"
                            selectable="1"
                            href="{{ route('login') }}"
                            selected="{{ Route::currentRouteName() == 'login'}}"
                        />
                        <x-menus.menu-item
                            content="Sign Up"
                            selectable="1"
                            href="{{ route('register') }}"
                            selected="{{ Route::currentRouteName() == 'register'}}"
                        />
                    @endauth
                </div>
                <!-- Hamburger -->
                <div class="absolute right-0 top-0 flex sm:hidden pt-3 pe-3 text-black dark:text-gray-50">
                    <button id="hamburger_btn">
                        <svg class="h-8 w-8" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path id="hamburger_btn_open" stroke-linecap="round" stroke-linejoin="round"
                                  stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            <path class="invisible" id="hamburger_btn_close" stroke-linecap="round"
                                  stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Heading -->
    <header class="bg-white dark:bg-gray-900 shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h4 class="mb-1 text-base text-gray-500 dark:text-gray-400 leading-tight">
                Cinemagic Theatres
            </h4>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                @yield('header-title')
            </h2>
        </div>
    </header>

    <main>
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            @if (session('alert-msg'))
                <x-alert type="{{ session('alert-type') ?? 'info' }}">
                    {!! session('alert-msg') !!}
                </x-alert>
            @endif
            @if (!$errors->isEmpty())
                <x-alert type="warning" message="Operation failed because there are validation errors!"/>
            @endif
            @yield('main')
        </div>
    </main>

</div>
<footer
    class="left-0 z-20 w-full p-4 bg-white border-t border-gray-200 shadow md:flex md:items-center md:justify-between md:p-6 dark:bg-gray-900 dark:border-gray-600">
    <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2024 <a href="{{route('home')}}"
                                                                                    class="hover:underline">Cinemagic</a>. Diogo Abegão, João Parreira, Pedro Barbeiro.
    </span>
    <ul class="flex flex-wrap items-center mt-3 text-sm font-medium text-gray-500 dark:text-gray-400 sm:mt-0">
        <li>
            <a href="#" class="hover:underline me-4 md:me-6">About</a>
        </li>
        <li>
            <a href="#" class="hover:underline me-4 md:me-6">Privacy Policy</a>
        </li>
        <li>
            <a href="#" class="hover:underline me-4 md:me-6">Licensing</a>
        </li>
        <li>
            <a href="#" class="hover:underline">Contact</a>
        </li>
    </ul>
</footer>
</body>

</html>

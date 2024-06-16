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
                <div class="flex justify-start sm:justify-center items-center">
                    <a href="{{ route('home') }}">
                        <div
                                class="h-16 w-40 mr-2 bg-contain bg-no-repeat bg-center bg-[url('../img/cinemagic.png')] dark:bg-[url('../img/cinemagic_dark.png')]">
                        </div>
                    </a>
                </div>


                <!-- Menu Items -->
                <div id="menu-container" class="grow flex flex-col sm:flex-row items-stretch
                    invisible h-0 sm:visible sm:h-auto ml-4">

                    <!-- Menu Item: What's On -->
                    <x-menus.menu-item
                            content="What's On"
                            href="{{ route('movies.showcase') }}"
                            selected="{{ Route::currentRouteName() == 'movies.showcase'}}"
                    />

                    @if(Auth::user()?->type == 'E')
                        <x-menus.menu-item
                                content="Screenings"
                                href="{{ route('screenings.index', ['date' => now()->format('Y-m-d')]) }}"
                                selected="{{ Route::currentRouteName() == 'screenings.index'}}"
                        />
                    @endif
                    @if(Auth::user()?->type == 'A')
                        <!-- Menu Item: Admin -->
                        <x-menus.submenu class="relative z-20"
                                         selectable="0"
                                         uniqueName="submenu_movies"
                                         content="Administration">
                            @can('viewAny', App\Models\Theater::class)
                                <x-menus.submenu-item
                                        content="Theaters"
                                        selectable="0"
                                        href="{{ route('theaters.index') }}"/>
                            @endcan
                            @can('viewAny', App\Models\Movie::class)
                                <x-menus.submenu-item
                                        content="Movies"
                                        selectable="0"
                                        href="{{ route('movies.index') }}"
                                />
                            @endcan
                            @can('viewAny', App\Models\Genre::class)
                                <x-menus.submenu-item
                                        content="Genres"
                                        selectable="0"
                                        href="{{ route('genres.index') }}"/>
                            @endcan
                            @can('viewAny', App\Models\Screening::class)
                                <x-menus.submenu-item
                                        content="Screenings"
                                        selectable="0"
                                        href="{{ route('screenings.index') }}"/>
                            @endcan
                            @can('viewAny', App\Models\Customer::class)
                                    <hr class="dark:border-gray-700">
                                <x-menus.submenu-item
                                        content="Customers"
                                        selectable="0"
                                        href="{{ route('customers.index') }}"/>
                            @endcan
                            @can('viewAny', App\Models\User::class)
                                <x-menus.submenu-item
                                        content="Staff"
                                        selectable="0"
                                        href="{{ route('users.index') }}"/>
                            @endcan
                        </x-menus.submenu>

                        <!-- Menu Item: Statistics -->
                        @can('viewStatistics', App\Models\User::class)
                            <x-menus.submenu class="relative z-20"
                                             selectable="0"
                                             uniqueName="submenu_movies"
                                             content="Statistics">
                                <x-menus.submenu-item
                                        content="Overall Statistics"
                                        selectable="0"
                                        href="{{ route('statistics.overall', ['start_date' => now()->subDays(30)->format('Y-m-d')]) }}"/>
                                <hr class="dark:border-gray-700">
                                <x-menus.submenu-item
                                        content="Statistics by Theater"
                                        selectable="0"
                                        href="{{ route('statistics.theater', ['start_date' => now()->subDays(30)->format('Y-m-d')]) }}"/>
                                <x-menus.submenu-item
                                        content="Statistics by Movie"
                                        selectable="0"
                                        href="{{ route('statistics.movie', ['start_date' => now()->subDays(30)->format('Y-m-d')]) }}"/>
                                <x-menus.submenu-item
                                        content="Statistics by Screening"
                                        selectable="0"
                                        href="{{ route('statistics.screening', ['start_date' => now()->subDays(30)->format('Y-m-d')]) }}"/>
                                <x-menus.submenu-item
                                        content="Statistics by Customer"
                                        selectable="0"
                                        href="{{ route('statistics.customer', ['start_date' => now()->subDays(30)->format('Y-m-d')]) }}"/>
                            </x-menus.submenu>
                        @endcan

                        <!-- Menu Item: Settings-->
                        <x-menus.menu-item
                                content="Configurations"
                                selectable="1"
                                href="{{ route('configurations.show', ['configuration' => '1']) }}"
                                selected="{{ Route::currentRouteName() == 'configurations.show'}}"
                        />
                    @endif

                    <div class="grow"></div>

                    <!-- Menu Item: Cart -->
                    @if (session('cart'))
                        @can('use-cart')
                            <x-menus.cart
                                    :href="route('cart.show')"
                                    selectable="1"
                                    selected="{{ Route::currentRouteName() == 'cart.show'}}"
                                    :total="count(session('cart'))"/>
                        @endcan
                    @endif

                    @auth
                        <x-menus.submenu class="relative z-20"
                                         selectable="0"
                                         uniqueName="submenu_user"
                        >
                            <x-slot:content>
                                <div class="pe-1">
                                    <img src="{{ Auth::user()->photoFullUrl}}"
                                         class="w-11 h-11 min-w-11 min-h-11 rounded-full" alt="user">
                                </div>
                                {{-- ATENÇÃO - ALTERAR FORMULA DE CALCULO DAS LARGURAS MÁXIMAS QUANDO O MENU FOR ALTERADO --}}
                                <div
                                        class="ps-1 sm:max-w-[calc(100vw-39rem)] md:max-w-[calc(100vw-41rem)] lg:max-w-[calc(100vw-46rem)] xl:max-w-[34rem] truncate">
                                    {{ Auth::user()->name }}
                                </div>
                            </x-slot:content>
                            @auth
                                <hr class="dark:border-gray-700">
                                @if(Auth::user()->type == 'C')
                                    <x-menus.submenu-item
                                            content="My Profile"
                                            selectable="0"
                                            href="{{route('customers.show', ['customer' => Auth::user()->customer])}}"
                                    />
                                @elseif(Auth::user()->type == 'A')
                                    <x-menus.submenu-item
                                            content="Profile"
                                            selectable="0"
                                            href="{{route('users.show', ['user' => Auth::user()])}}"
                                    />
                                @endif
                                @if(Auth::user()->type == 'C')
                                    <x-menus.submenu-item
                                            content="Purchases"
                                            selectable="0"
                                            href="{{ route('purchases.index', ['customer' => auth()->user()]) }}"/>
                                @endif
                                <x-menus.submenu-item
                                        content="Change Password"
                                        selectable="0"
                                        href="{{ route('profile.edit.password') }}"/>
                            @endauth
                            <hr class="dark:border-gray-700">
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
            <h4 class="text-base text-gray-500 dark:text-gray-400 leading-tight mb-4">
                Cinemagic Theatres
            </h4>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                @yield('header-title')
            </h2>
        </div>

        @php
            $validating = session('screening', null);
        @endphp

        @if(Auth::user()?->type == 'E' && $validating)
            <div class="flex flex-row shadow border-t dark:border-t-gray-600 bg-slate-100 dark:bg-gray-700 justify-center">
                <h2 class="p-3 text-gray-800 dark:text-gray-200 leading-tight">
                    Validating Tickets for screening : {{$validating['id']}} | {{$validating['movie']->title}} | {{$validating['date']}} | {{$validating['start_time']}}
                </h2>
                <form action="{{ route('screenings.cancel-verify', ['screening' => $validating])}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <x-button element="submit" type="light" text="Stop Validation" class="p-1"/>
                </form>
            </div>
        @endif
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

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css"> --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="https://kit.fontawesome.com/f3136aef18.js" crossorigin="anonymous"></script>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            overflow-x: hidden;
            background: rgb(250, 247, 247);
        }

        .app-background {
            background-image: url('/images/another.jpg');
            width: 100%;
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
        }

        /* width */
        ::-webkit-scrollbar {
            width: 10px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        .mobile-dropdown {
            max-height: 0;
            transition: max-height 0.5s ease-in-out;
        }

        .animate {
            max-height: 35rem;
        }

        .product-card {
            background-color: white;
            width: 45%;
            margin: 2.5%;
            border-radius: 0.25rem;
        }
        
        .product-card:hover {
            box-shadow: 1px 1px 5px rgb(83, 81, 81);
        }

        .product-card img {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(1);
            width: auto;
            height: auto;
            max-height: 100%;
            max-width: 100%;
            transition: all 0.2s ease-in-out;
        }

        .product-card:hover img {
            transform: translate(-50%, -50%) scale(1.1);
        }

        .cart-image {
        }
        
        .cart-image img {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: auto;
            height: auto;
            max-height: 100%;
            max-width: 100%;
        }

        .single-card {
            background-color: white;
            height: 50vh;
        }

        .single-card img {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: auto;
            height: auto;
            max-height: 100%;
            max-width: 100%;
            transition: ease-in-out 0.5s all;
        }

        .single-card img:hover {
            transform: translate(-50%, -50%) scale(1.2);
        }

        .modal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 19;
            background: rgba(0, 0, 0, 0.505);
            padding: 5%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            width: 90vw;
            max-height: 90vh;
            overflow-y: auto;
        }

        #desktopSearch input {
            border: none;
            padding: 0;
            width: 0;
            transition: width 0.5s;
        }

        #desktopSearch .activeInput {
            width: 20rem;
            border: 1px solid black;
            border-radius: 4px;
            padding: 5px;
        }

        #customerCare {
            z-index: 15;
        }

        .alert {
            position: fixed;
            z-index: 40;
            top: 50px;
            left: 0;
            right: 0;
            animation: alert-fade 4s;
            animation-fill-mode: forwards;
        }

        .loader {
            border: 3px solid #f5f0f0; /* Light grey */
            border-top: 3px solid #3498db; /* Blue */
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes alert-fade {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 1;
            }

            80% {
                top: 50px;
            }
            
            100% {
                opacity: 0;
                top: -50px;
            }
        }

        @media screen and (min-width: 600px) {
            .product-card {
                width: 20%;
                margin: 2.5%;
            }

            .modal {
                padding: 20%;
            }

            .modal-content {
                width: 40vw;
            }
        }
    </style>
</head>

<body class="antialiased">
    <div class="flex flex-col min-h-screen w-screen relative">
        <div x-data="{ open: false }" class="z-10 fixed inset-x-0 top-0">
            <div class="flex justify-between px-8 md:px-0 items-center bg-white shadow-md">
                <a href="/"><img src="/images/app-logo.svg" alt="" class="w-37 h-16 pl-11"></a>
                <nav class="flex justify-evenly items-stretch">
                    <a href="{{ route('products') }}" class="{{request()->routeIs('products') ? 'border-blue-600 text-blue-500' : 'border-white'}} border-b-4 pt-3 pb-2 hidden md:inline mx-4">
                        <i class="material-icons hover:text-blue-500" style='font-size: 36px; line-height: inherit'>
                            apps
                        </i>
                    </a>
                    {{-- <a href="{{ route('cart') }}" class="hidden md:inline mx-4">
                        <i class="material-icons hover:text-blue-500" style='font-size: 36px; line-height: inherit'>
                            shopping_cart
                        </i>
                    </a> --}}

                    {{-- React Component 'DesktopCartComponent' --}}
                    @auth
                        <div id="desktopCart" data-id="{{Auth::user()->id}}" class="{{request()->routeIs('cart') ? 'border-blue-600 text-blue-500' : 'border-white'}} border-b-4 pt-3 pb-2 flex"></div>
                    @else    
                        <div id="desktopCart" class="border-white border-b-4 pt-3 pb-2 flex"></div>
                    @endauth
                
                    {{-- React component 'DesktopSearchComponent' --}}
                    <div id="desktopSearch" class="flex"></div>
                    
                    <!-- Hamburger -->
                    @auth
                    <div class="{{request()->routeIs('profile') ? 'border-blue-600 text-blue-500' : 'border-white'}} border-b-4 hidden sm:flex sm:items-center sm:ml-6">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="{{request()->routeIs('profile') ? 'text-blue-500' : 'text-gray-700'}} flex items-center text-xl font-bold hover:text-blue-500 hover:border-blue-300 focus:outline-none focus:text-blue-700 focus:border-blue-300">
                                    <i class="material-icons hover:text-blue-500" style='font-size: 36px; line-height: inherit'>
                                        person
                                    </i>

                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <!-- Authentication -->
                                <x-dropdown-link :href="route('profile')">
                                    {{ __('Profile') }}
                                </x-dropdown-link>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                                                                this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                    @else
                    <a href="{{ route('login') }}" class="border-white border-b-4 pt-3 pb-2 mx-4 hidden sm:inline">
                        <i class="material-icons hover:text-blue-500" style='font-size: 36px; line-height: inherit'>
                            exit_to_app
                        </i>
                    </a>
                    @endauth
                    <div class="-mr-2 flex items-center sm:hidden">
                        <button @click="open = ! open"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </nav>
            </div>
            <div :class="{'animate': open}"
                class="block overflow-hidden mobile-dropdown shadow-md sm:hidden bg-white">

                <!-- Responsive Settings Options -->
                <div class="border-t border-gray-200">
                    @auth
                    <div class="p-5 border-b border-gray-300">
                        <div class="font-medium text-lg text-gray-800">Logged in as:</div>
                        <div class="font-medium text-lg text-gray-800">{{ Auth::user()->name }}</div>
                        {{-- <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div> --}}
                    </div>
                    @endauth
                    <div class="py-3 space-y-1 border-b border-gray-300">
                        <x-responsive-nav-link :href="route('/')" :active="request()->routeIs('/')">
                            <x-slot name="slot">
                                <div class="flex items-center">
                                    <i class="material-icons hover:text-blue-500" style='font-size: 36px; line-height: inherit'>
                                        home
                                    </i>
                                    <p class="ml-3">Home</p>
                                </div>
                            </x-slot>
                        </x-responsive-nav-link>
                    </div>
                    <div class="py-3 space-y-1 border-b border-gray-300">
                        <x-responsive-nav-link :href="route('products')" :active="request()->routeIs('products')">
                            <x-slot name="slot">
                                <div class="flex items-center">
                                    <i class="material-icons hover:text-blue-500" style='font-size: 36px; line-height: inherit'>
                                        apps
                                    </i>
                                    <p class="ml-3">Products</p>
                                </div>
                            </x-slot>
                        </x-responsive-nav-link>
                    </div>

                    {{-- React Component "MobileSearchComponent" --}}
                    <div id="mobileSearch"></div>

                    <div class="py-3 space-y-1 border-b border-gray-300">
                        <x-responsive-nav-link :href="route('cart')" :active="request()->routeIs('cart')">
                            <div class="flex items-center">
                                <i class="material-icons hover:text-blue-500" style='font-size: 36px; line-height: inherit'>
                                    shopping_cart
                                </i>
                                <p class="ml-3">Cart</p>
                            </div>
                        </x-responsive-nav-link>
                    </div>
                    @auth
                    <div class="py-3 space-y-1 border-b border-gray-300">
                        <x-responsive-nav-link :href="route('profile')" :active="request()->routeIs('profile')">
                            <div class="flex items-center">
                                <i class="material-icons hover:text-blue-500" style='font-size: 36px; line-height: inherit'>
                                    person
                                </i>
                                <p class="ml-3">Profile</p>
                            </div>
                        </x-responsive-nav-link>
                    </div>
                    <div class="py-3 space-y-1">
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                <div class="flex items-center">
                                    <i class="material-icons hover:text-blue-500" style='font-size: 36px; line-height: inherit'>
                                        exit_to_app
                                    </i>
                                    <p class="ml-3">Logout</p>
                                </div>
                            </x-responsive-nav-link>
                        </form>
                    </div>
                    @else
                    <div class="py-3 space-y-1 border-b border-gray-300">
                        <x-responsive-nav-link :href="route('login')" :active="request()->routeIs('login')">
                            <div class="flex items-center">
                                <i class="material-icons hover:text-blue-500" style='font-size: 36px; line-height: inherit'>
                                    exit_to_app
                                </i>
                                <p class="ml-3">Login</p>
                            </div>
                        </x-responsive-nav-link>
                    </div>
                    @endauth
                </div>
            </div>
        </div>
        
        @yield('content')

        <div class="flex flex-col md:flex-row justify-evenly items-center md:items-start pt-10 pb-5" style="background-color: rgb(19, 19, 19)">
            <img class="m-10 w-40 h-25" src="/images/app-log.svg" alt="" />
            <div class="m-10 px-10 text-center md:w-1/3">
                <p class="text-2xl text-gray-200">About This Website</p>
                <p class="mt-5 text-lg text-gray-400">
                    Gamers-Hub is the the place to be if you're a serious gamer and looking for the best accessories. It is an online shopping mall for the best Gamers.
                    We provide good services and customer care
                </p>
            </div>
            <div class="m-10 ms:w-1/3">
                <p class="text-2xl text-gray-200 text-center">Where you can find us</p>
                <div class="flex justify-evenly mt-8">
                    <a href="" class="">
                        <i class="mx-4 fab fa-facebook-f text-blue-500 hover:text-blue-800 transition duration-500 ease-in-out transform hover:-translate-y-1 hover:scale-105" style='font-size: 40px; line-height: inherit'>
                        </i>
                    </a>
                    <a href="" class="">
                        <i class="mx-4 fab fa-twitter text-blue-500 hover:text-blue-800 transition duration-500 ease-in-out transform hover:-translate-y-1 hover:scale-105" style='font-size: 40px; line-height: inherit'>
                        </i>
                    </a>
                    <a href="" class="">
                        <i class="mx-4 fab fa-instagram text-blue-500 hover:text-blue-800 transition duration-500 ease-in-out transform hover:-translate-y-1 hover:scale-105" style='font-size: 40px; line-height: inherit'>
                        </i>
                    </a>
                    <a href="" class="">
                        <i class="mx-4 fab fa-whatsapp text-blue-500 hover:text-blue-800 transition duration-500 ease-in-out transform hover:-translate-y-1 hover:scale-105" style='font-size: 40px; line-height: inherit'>
                        </i>
                    </a>
                </div>
            </div>
        </div>
        <div class="bg-gray-600 text-gray-200 p-2 text-center text-lg">© 2025 Copyright: Gamers-Hub</div>
        
        @include('include.feedback')
        
        @auth
            <div id="customerCare" data-id="{{Auth::user()->id}}" class="shadow-xl fixed right-10 bottom-10" style="border-radius: 50%"></div>
        @endauth
    </div>
</body>

</html>
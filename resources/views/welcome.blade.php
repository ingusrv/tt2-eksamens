<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-white dark:bg-neutral-800 text-neutral-900 dark:text-neutral-100">
            <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-amber-600 selection:text-white">
                <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                    <header class="grid grid-cols-1 sm:grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                        <div class="flex lg:justify-center lg:col-start-2"></div>
                        @if (Route::has('login'))
                            <nav class="-mx-3 flex flex-1 justify-end *:text-nowrap">
                                @auth
                                    <a
                                        href="#about"
                                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                    >
                                        {{__("About")}}
                                    </a>
                                    <a
                                        href="#useage"
                                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                    >
                                        {{__("Useage")}}
                                    </a>
                                    <a
                                        href="{{ url('/dashboard') }}"
                                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                    >
                                        {{__("Dashboard")}}
                                    </a>
                                    <div class="flex rounded-md px-3 py-2">
                                        <x-dropdown align="right" width="48">
                                            <x-slot name="trigger">
                                                <button class="inline-flex items-center border border-transparent text-sm leading-4 rounded-md hover:text-black/70 dark:text-white dark:hover:text-white/80 focus:outline-none transition ease-in-out duration-150">
                                                    <div>{{app()->currentLocale()}}</div>

                                                    <div class="ms-1">
                                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                </button>
                                            </x-slot>

                                            <x-slot name="content">
                                                <x-dropdown-link :href="route('locale.set', 'en')">
                                                    {{__('English')}}
                                                </x-dropdown-link>
                                                <x-dropdown-link :href="route('locale.set', 'lv')">
                                                    {{__('Latvian')}}
                                                </x-dropdown-link>
                                            </x-slot>
                                        </x-dropdown>
                                    </div>
                                @else
                                    <a
                                        href="#about"
                                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                    >
                                        {{__("About")}}
                                    </a>
                                    <a
                                        href="#useage"
                                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                    >
                                        {{__("Useage")}}
                                    </a>
                                    <a
                                        href="{{ route('login') }}"
                                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                    >
                                        {{__("Log in")}}
                                    </a>

                                    @if (Route::has('register'))
                                        <a
                                            href="{{ route('register') }}"
                                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                        >
                                            {{__("Register")}}
                                        </a>
                                    @endif
                                    <div class="flex rounded-md px-3 py-2">
                                        <x-dropdown align="right" width="48">
                                            <x-slot name="trigger">
                                                <button class="inline-flex items-center border border-transparent text-sm leading-4 rounded-md hover:text-black/70 dark:text-white dark:hover:text-white/80 focus:outline-none transition ease-in-out duration-150">
                                                    <div>{{app()->currentLocale()}}</div>

                                                    <div class="ms-1">
                                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                </button>
                                            </x-slot>

                                            <x-slot name="content">
                                                <x-dropdown-link :href="route('locale.set', 'en')">
                                                    {{__('English')}}
                                                </x-dropdown-link>
                                                <x-dropdown-link :href="route('locale.set', 'lv')">
                                                    {{__('Latvian')}}
                                                </x-dropdown-link>
                                            </x-slot>
                                        </x-dropdown>
                                    </div>
                                @endauth
                            </nav>
                        @endif
                    </header>

                    <main class="mt-6">
                        <h1 class="text-5xl font-bold text-center">{{ config('app.name', 'Laravel') }}</h1>
                        <p class="mt-4 max-w-2xl mx-auto text-2xl text-center">
                            {{__("Arrange your plans, tasks and other things all in one place.")}}
                        </p>
                        <div class="mt-6 flex flex-row gap-4 justify-center">
                            @auth
                                <a href="{{ url('/dashboard') }}">
                                    <x-primary-button>{{__("Dashboard")}}</x-primary-button>
                                </a>
                            @else
                                <a href="{{ route('login') }}">
                                    <x-primary-button>{{__("Log in")}}</x-primary-button>
                                </a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}">
                                        <x-secondary-button>{{__("Register")}}</x-secondary-button>
                                    </a>
                                @endif
                            @endauth

                        </div>

                        <h2 class="mt-48 text-4xl font-bold text-center" id="about">{{__("About the product")}}</h2>
                        <p class="mt-4 max-w-2xl mx-auto text-xl text-center">
                            {{ config('app.name', 'Laravel') }} {{__("is a website where users can create and share Kanban boards to manage projects and tasks efficiently. It offers a visual and intuitive interface, allowing users to organize tasks into columns representing different stages of progress. Users can sharing these boards with each other, allowing for easy collaboration with team members.")}}
                        </p>

                        <div class="mt-8 grid grid-cols-1 sm:grid-cols-4 gap-4 *:p-6 *:bg-white *:dark:bg-neutral-700/50 *:border *:border-neutral-500 *:rounded-lg *:flex *:flex-col *:gap-y-4 *:items-center *:text-center">
                            <div>
                                <h3 class="text-2xl font-bold">{{__("Fast")}}</h3>
                                <p class="mb-6 text-lg text-center">
                                    {{__("Our site is optimized to work smoothly on any device.")}}
                                </p>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold">{{__("Free")}}</h3>
                                <p class="mb-6 text-lg text-center">
                                    {{__("Our solution is free! All you need to do is create an account.")}}
                                </p>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold">{{__("Intuitive UI")}}</h3>
                                <p class="mb-6 text-lg text-center">
                                    {{__("Our user interface is very intuitive. It is well designed and very easy to use.")}}
                                </p>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold">{{__("Everything Synced")}}</h3>
                                <p class="mb-6 text-lg text-center">
                                    {{__("Your work will be instantly synchronised with your other devices.")}}
                                </p>
                            </div>
                        </div>

                        <h2 class="mt-24 text-4xl font-bold text-center" id="useage">{{__("How to get started?")}}</h2>
                        <ol class="max-w-lg mt-4 mx-auto text-xl list-decimal marker:font-bold marker:text-amber-600">
                            <li>
                                {{__("Go to the new user registration")}}
                            </li>
                            <li>
                                {{__("Create a new account using an email and password")}}
                            </li>
                            <li>
                                {{__("Verify your account by clicking on the link sent to your email")}}
                            </li>
                            <li>
                                {{__("Log in with your newly verified account")}}
                            </li>
                            <li>
                                {{__("Done! Now you can start using the app.")}}
                            </li>
                        </ol>
                    </main>

                    <footer class="py-16 text-center text-sm text-black dark:text-white/70">
                        &copy; 2024 ingusrv
                    </footer>
                </div>
            </div>
    </body>
</html>

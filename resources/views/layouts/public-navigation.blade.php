<nav x-data="{ open: false }" class="bg-white dark:bg-neutral-800 border-b border-neutral-100 dark:border-neutral-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('index') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-neutral-800 dark:text-neutral-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('index')">
                        {{ __('Main page') }}
                    </x-nav-link>
                </div>
            </div>

            <div class="flex">
                <!-- Language Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-neutral-500 dark:text-neutral-400 bg-white dark:bg-neutral-800 hover:text-neutral-700 dark:hover:text-neutral-300 focus:outline-none transition ease-in-out duration-150">
                                <div>{{__("Language")}}</div>

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

                <!-- Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-neutral-500 dark:text-neutral-400 bg-white dark:bg-neutral-800 hover:text-neutral-700 dark:hover:text-neutral-300 focus:outline-none transition ease-in-out duration-150">
                        <div>{{__("Guest")}}</div>
                    </button>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-neutral-400 dark:text-neutral-500 hover:text-neutral-500 dark:hover:text-neutral-400 hover:bg-neutral-100 dark:hover:bg-neutral-900 focus:outline-none focus:bg-neutral-100 dark:focus:bg-neutral-900 focus:text-neutral-500 dark:focus:text-neutral-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('index')">
                {{ __('Main page') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Language Options -->
        <div class="pt-4 pb-1 border-t border-neutral-200 dark:border-neutral-600">
            <div class="px-4">
                <div class="font-medium text-base text-neutral-800 dark:text-neutral-200">{{__("Language")}}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('locale.set', 'en')">
                    {{__("English")}}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('locale.set', 'lv')">
                    {{__("Latvian")}}
                </x-responsive-nav-link>
            </div>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-neutral-200 dark:border-neutral-600">
            <div class="px-4">
                <div class="font-medium text-base text-neutral-800 dark:text-neutral-200">{{__("Guest")}}</div>
            </div>

            <div class="mt-3 space-y-1"></div>
        </div>
    </div>
</nav>

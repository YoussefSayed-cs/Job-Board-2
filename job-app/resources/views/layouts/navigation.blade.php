<nav x-data="{ open: false, scrambled: false }" 
     @scroll.window="scrambled = (window.pageYOffset > 20)"
     :class="{ 'bg-black/40 backdrop-blur-md border-white/10': scrambled, 'bg-transparent border-transparent': !scrambled }"
     class="fixed w-full z-50 transition-all duration-300 border-b">
    
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">
            <div class="flex items-center gap-8">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="group">
                        <x-application-logo class="block h-9 w-auto fill-current text-white group-hover:text-brand-400 transition-colors" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" 
                        class="text-white/80 hover:text-white transition-colors duration-300">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <x-nav-link :href="route('job-applications.index')" :active="request()->routeIs('job-applications.*')" 
                        class="text-white/80 hover:text-white transition-colors duration-300">
                        {{ __('My Applications') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6 gap-4">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2 border border-white/10 text-sm font-medium rounded-full text-white bg-white/5 hover:bg-white/10 focus:outline-none transition ease-in-out duration-300">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ml-2">
                                <svg class="fill-current h-4 w-4 text-white/60" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="bg-black/90 backdrop-blur-xl border border-white/10 rounded-lg overflow-hidden">
                            <x-dropdown-link :href="route('profile.edit')" class="text-white hover:bg-white/10">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();" 
                                        class="text-red-400 hover:bg-red-500/10">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-white hover:bg-white/10 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-black/90 backdrop-blur-xl border-t border-white/10">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('job-applications.index')" :active="request()->routeIs('job-applications.index')" class="text-white">
                 {{ __('My Applications') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-white/10">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-white/60">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-white">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-400">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

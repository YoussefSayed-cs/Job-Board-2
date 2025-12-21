<nav class="w-[250px] bg-white h-screen border-r border-gray-200">
    <!-- Logo Section -->
    <div class="flex items-center px-6 border-b border-gray-200 py-4">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
            <x-application-logo class="h-6 w-auto fill-current text-gray-800" />
            <span class="text-lg font-semibold text-gray-800">{{ __('Shaghalni') }}</span>
        </a>
    </div>

    <!-- Navigation Links -->
    <ul class="flex flex-col px-4 py-6 space-y-4">
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            {{ __('Dashboard') }}
        </x-nav-link>

        @if (auth()->user()->role == 'admin')
            <x-nav-link :href="route('companies.index')" :active="request()->routeIs('companies.*')">
                {{ __('Companies') }}
            </x-nav-link>
        @endif

        @if (auth()->user()->role == 'company-owner')
            <x-nav-link :href="route('my-company.show')" :active="request()->routeIs('my-company.*')">
                My Company
            </x-nav-link>
        @endif

        <!-- Applications - استخدم job-applications.* كما في ملف الروات -->
        <x-nav-link :href="route('job-applications.index')" 
                    :active="request()->routeIs('job-applications.*')">
            {{ __('Applications') }}
        </x-nav-link>

        @if (auth()->user()->role == 'admin')
            <!-- Categories - استخدم job-categories.* كما في ملف الروات -->
            <x-nav-link :href="route('job-categories.index')" 
                        :active="request()->routeIs('job-categories.*')">
                {{ __('Categories') }}
            </x-nav-link>
        @endif

        <x-nav-link :href="route('job-vacancies.index')" :active="request()->routeIs('job-vacancies.*')">
            {{ __('Job Vacancies') }}
        </x-nav-link>
        
        @if (auth()->user()->role == 'admin')
            <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                {{ __('Users') }}
            </x-nav-link>
        @endif

        <hr />
        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}" class="mt-4">
            @csrf
            <x-nav-link class="text-red-500" :href="route('logout')"
                onclick="event.preventDefault(); this.closest('form').submit();">
                {{ __('Log Out') }}
            </x-nav-link>
        </form>
    </ul>
</nav>
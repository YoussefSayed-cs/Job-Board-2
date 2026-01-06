<nav class="w-72 bg-slate-900 min-h-screen flex flex-col shadow-2xl z-20 transition-all duration-300">
    <!-- Logo -->
    <div class="flex items-center px-8 py-6 border-b border-white/10">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
            <x-application-logo class="h-8 w-auto text-brand-400 transition-transform group-hover:scale-110" />
            <span class="text-xl font-bold text-white tracking-tight">Shagalni<span class="text-brand-500">.</span></span>
        </a>
    </div>

    <!-- User Profile Snippet (Mobile/Desktop sidebar header) -->
    <div class="px-6 py-4 border-b border-white/5">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-brand-500/20 flex items-center justify-center text-brand-400 font-bold border border-brand-500/30">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div class="overflow-hidden">
                <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</p>
                <p class="text-xs text-slate-400 truncate capitalize">{{ Auth::user()->role }}</p>
            </div>
        </div>
    </div>

    <!-- Links -->
    <ul class="flex-1 flex flex-col px-4 py-6 space-y-1 overflow-y-auto custom-scrollbar">
        
        <x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="home">
            Dashboard
        </x-sidebar-link>

        <div class="pt-4 pb-2 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">
            Management
        </div>

        @if(auth()->user()->role === 'admin')
            <x-sidebar-link :href="route('companies.index')" :active="request()->routeIs('companies.*')" icon="building">
                Companies
            </x-sidebar-link>
            
            <x-sidebar-link :href="route('job-categories.index')" :active="request()->routeIs('job-categories.*')" icon="tag">
                Categories
            </x-sidebar-link>
            
            <x-sidebar-link :href="route('users.index')" :active="request()->routeIs('users.*')" icon="users">
                Users
            </x-sidebar-link>
        @endif

        @if(auth()->user()->role === 'company-owner')
            <x-sidebar-link :href="route('my-company.show')" :active="request()->routeIs('my-company.*')" icon="building">
                My Company
            </x-sidebar-link>
        @endif

        <div class="pt-4 pb-2 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">
            Recruitment
        </div>

        <x-sidebar-link :href="route('job-applications.index')" :active="request()->routeIs('job-applications.*')" icon="clipboard">
            Applications
        </x-sidebar-link>

        <x-sidebar-link :href="route('job-vacancies.index')" :active="request()->routeIs('job-vacancies.*')" icon="briefcase">
            Job Vacancies
        </x-sidebar-link>
        

    </ul>

    <!-- Logout -->
    <div class="p-4 border-t border-white/10 bg-black/20">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" 
                    class="w-full flex items-center gap-3 px-4 py-2.5 rounded-lg text-red-400 hover:bg-red-500/10 hover:text-red-300 transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                <span class="font-medium">Log Out</span>
            </button>
        </form>
    </div>
</nav>

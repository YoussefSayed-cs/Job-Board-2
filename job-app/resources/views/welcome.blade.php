<x-main-layout> 
    
    <div class="min-h-screen flex flex-col items-center justify-center relative">
        
        <!-- Tag -->
        <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 300)">
            <div class="inline-flex items-center mb-6" x-cloak x-show="show"
                 x-transition:enter="transition ease-out duration-700"
                 x-transition:enter-start="opacity-0 scale-90"
                 x-transition:enter-end="opacity-100 scale-100">
        
                <span class="px-4 py-1.5 rounded-full border border-white/10 bg-white/5 text-sm my-4 font-medium text-brand-200 shadow-lg backdrop-blur-md">
                    ✨ Your Future Awaits at Shagalni
                </span>
            </div>
        </div>

        <!-- Hero Title -->
        <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 500)" class="text-center max-w-4xl px-4">
            <h1 x-cloak x-show="show"
                 x-transition:enter="transition ease-out duration-700"
                 x-transition:enter-start="opacity-0 transform translate-y-10"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 class="text-5xl sm:text-7xl md:text-8xl font-black tracking-tight mb-8 leading-tight">
                <span class="text-white drop-shadow-2xl">Find your</span>
                <span class="bg-gradient-to-r from-brand-400 via-indigo-400 to-purple-400 bg-clip-text text-transparent">Dream Job</span>
            </h1>
            
            <p x-cloak x-show="show"
                x-transition:enter="transition ease-out duration-700 delay-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                class="text-lg md:text-xl text-white/60 max-w-2xl mx-auto mb-10 font-light">
                Connect with top-tier employers, showcase your skills, and land the opportunity you've been waiting for.
            </p>

            <!-- Buttons -->
            <div x-cloak x-show="show"
                 x-transition:enter="transition ease-out duration-700 delay-300"
                 x-transition:enter-start="opacity-0 transform translate-y-5"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 class="flex flex-col sm:flex-row gap-4 justify-center items-center">
        
                <a href="{{ route('register') }}"
                   class="group relative inline-flex items-center justify-center px-8 py-3.5 text-base font-bold text-white transition-all duration-200 bg-brand-600 font-pj rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-600 hover:bg-brand-700 hover:shadow-lg hover:shadow-brand-600/30 hover:-translate-y-1">
                    Create an Account
                    <svg class="w-5 h-5 ml-2 -mr-1 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                </a>
        
                <a href="{{ route('login') }}"
                   class="inline-flex items-center justify-center px-8 py-3.5 text-base font-bold text-white transition-all duration-200 bg-white/5 border border-white/10 font-pj rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 hover:bg-white/10 hover:border-white/20 backdrop-blur-sm hover:-translate-y-1">
                    Login
                </a>
        
            </div>
        </div>

    </div>

</x-main-layout>    

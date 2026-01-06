<x-auth-layout>
    <div class="auth-card">
        <!-- Accent Line -->
        <div class="absolute top-0 left-0 right-0 h-2 bg-indigo-600"></div>

        <!-- Branding Section -->
        <div class="flex flex-col items-center mb-10 fade-in-item animate-delay-1">
            <div class="p-4 bg-indigo-50 rounded-3xl mb-6 shadow-sm">
                <x-application-logo class="w-10 h-10 text-indigo-600 fill-current" />
            </div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Welcome Back</h1>
            <p class="text-slate-400 font-bold text-xs uppercase tracking-[0.2em] mt-2">Administrator Access</p>
        </div>

        <!-- Session Status Container -->
        <div class="fade-in-item animate-delay-2">
            <x-auth-session-status class="mb-8" :status="session('status')" />
        </div>

        <form action="{{ route('login') }}" method="POST" class="space-y-6 fade-in-item animate-delay-3">
            @csrf
            
            <!-- Email -->
            <div class="space-y-2">
                <label for="email" class="block text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Email Address</label>
                <div class="relative group">
                   
                    <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}" autofocus
                        class="block w-full pl-12 pr-4 py-4.5 bg-slate-50 border-2 border-transparent rounded-2xl text-slate-900 placeholder-slate-300 focus:border-indigo-600/10 focus:ring-4 focus:ring-indigo-600/5 focus:bg-white transition-all font-bold text-sm outline-none shadow-sm">
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2 ml-1" />
            </div>

            <!-- Password -->
            <div class="space-y-2" x-data="{ show: false }">
                <div class="flex justify-between items-center px-1">
                    <label for="password" class="block text-[11px] font-black text-slate-500 uppercase tracking-widest">Secret Key</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-[11px] font-black text-indigo-600 hover:text-indigo-400 transition-colors">Recover?</a>
                    @endif
                </div>
                <div class="relative group">
                    
                    <input id="password" name="password" :type="show ? 'text' : 'password'" autocomplete="current-password" required
                        class="block w-full pl-12 pr-14 py-4.5 bg-slate-50 border-2 border-transparent rounded-2xl text-slate-900 placeholder-slate-300 focus:border-indigo-600/10 focus:ring-4 focus:ring-indigo-600/5 focus:bg-white transition-all font-bold text-sm outline-none shadow-sm">
                    
                    <button
    type="button"
    @click="show = !show"
    class="absolute inset-y-0 right-3 flex items-center justify-center
           w-10 text-slate-400 hover:text-indigo-600
           z-50 pointer-events-auto">

                        <svg x-show="!show" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z" /></svg>
                        <svg x-show="show" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-cloak style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825a9.56 9.56 0 01-1.875.175c-4.478 0-8.268-2.943-9.542-7 1.002-3.364 3.843-6 7.542-7.575M15 12a3 3 0 00-6 0 3 3 0 006 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" /></svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 ml-1" />
            </div>

            <!-- Submit Button -->
            <button type="submit" 
                class="group w-full py-5 bg-slate-900 border-2 border-slate-900 text-white rounded-2xl font-black text-lg shadow-xl hover:bg-white hover:text-slate-900 transition-all duration-300 flex items-center justify-center gap-3 active:scale-[0.98]">
                Sign In
                <svg width="22" height="22" class="group-hover:translate-x-1.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
            </button>
        </form>

        <!-- Footer -->
        <div class="mt-12 text-center pt-8 border-t border-slate-100/50 fade-in-item animate-delay-5">
            <p class="text-[9px] font-black text-slate-300 uppercase tracking-[0.4em]">Enterprise Security Protocol • v2.0</p>
        </div>
    </div>
</x-auth-layout>
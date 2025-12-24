<div class="fixed bottom-5 left-5 z-50">
    @if (session('success'))
        <div x-data="{ show: false }" x-cloak x-init="
                        setTimeout(() => show = true, 50);
                        setTimeout(() => show = false, 3000);
                    " x-show="show"
             x-transition:enter="transition transform ease-out duration-500"
            x-transition:enter-start="opacity-0 scale-75" x-transition:enter-end="opacity-100 scale-105"
            x-transition:leave="transition transform ease-in duration-300" x-transition:leave-start="opacity-100 scale-105"
            x-transition:leave-end="opacity-0 scale-75"
            class="max-w-sm bg-green-600 text-white px-5 py-4 rounded-xl shadow-xl flex items-center gap-3" role="alert">
            <!-- Icon -->
            <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>

            <span class="text-sm font-semibold">
                {{ session('success') }}
            </span>
        </div>
    @endif
</div>
<div class="absolute inset-x-0 top-0 z-50">
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
            class="bg-green-100 border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
            role="alert">{{ session('success') }}</div>
        @endif
    </div>

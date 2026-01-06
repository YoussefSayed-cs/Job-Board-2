<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Shagalni</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-black text-white overflow-x-hidden selection:bg-brand-500 selection:text-white">
    
    <!-- Background Gradient Blobs -->
    <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
        <div class="absolute top-[-10%] left-[-10%] w-[500px] h-[500px] bg-brand-900/20 rounded-full blur-3xl animate-blob"></div>
        <div class="absolute top-[-10%] right-[-10%] w-[500px] h-[500px] bg-indigo-900/20 rounded-full blur-3xl animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-[-10%] left-[20%] w-[500px] h-[500px] bg-purple-900/20 rounded-full blur-3xl animate-blob animation-delay-4000"></div>
    </div>

    <!-- Content Wrapper -->
    <div class="relative z-10 min-h-screen flex flex-col">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="pt-28 pb-10 px-4 sm:px-6 lg:px-8">
                <div class="max-w-7xl mx-auto">
                    {{ $header }}
                </div>
            </header>
        @else
            <div class="pt-20"></div> {{-- Spacer if no header --}}
        @endisset

        <!-- Page Content -->
        <main class="flex-grow px-4 sm:px-6 lg:px-8 pb-12 animate-fade-in-up">
            <div class="max-w-7xl mx-auto">
                {{ $slot }}
            </div>
        </main>

        <!-- Modern Footer -->
        <footer class="border-t border-white/10 bg-black/50 backdrop-blur-sm py-12 mt-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-6">
                
                <div class="text-center md:text-left">
                    <h3 class="text-xl font-bold bg-gradient-to-r from-white to-white/60 bg-clip-text text-transparent mb-2">
                        Shagalni
                    </h3>
                    <p class="text-sm text-white/40">
                        Connecting talent with opportunity.
                    </p>
                </div>

                <div class="flex gap-6 text-sm text-white/60">
                    <a href="#" class="hover:text-brand-400 transition-colors">Privacy Policy</a>
                    <a href="#" class="hover:text-brand-400 transition-colors">Terms of Service</a>
                    <a href="#" class="hover:text-brand-400 transition-colors">Contact</a>
                </div>

                <div class="text-sm text-white/30">
                    &copy; {{ date('Y') }} Shagalni. All rights reserved.
                </div>
            </div>
        </footer>
    </div>
</body>

</html>
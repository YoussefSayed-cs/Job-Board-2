<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Backoffice - Shagalni</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="font-sans antialiased bg-slate-50 text-slate-800">
    <div class="flex min-h-screen">

        <!-- Sidebar -->
        @include('layouts.navigation')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">

            <!-- Header -->
            @isset($header)
                <header class="bg-white border-b border-slate-200 z-10">
                    <div class="px-8 py-5 flex justify-between items-center">
                        <div class="flex-1">
                            {{ $header }}
                        </div>
                        <div class="ml-4">
                            <x-notifications />
                        </div>
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 p-8">
                {{ $slot }}
            </main>

        </div>
    </div>
</body>
</html>

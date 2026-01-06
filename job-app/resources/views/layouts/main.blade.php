<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? 'Shagalni' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Alpine.js Cloak -->
    <style>
        [x-cloak] { display: none !important; }
        .animate-blob { animation: blob 7s infinite; }
        .animation-delay-2000 { animation-delay: 2s; }
        .animation-delay-4000 { animation-delay: 4s; }
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
    </style>

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-black text-white min-h-screen font-sans selection:bg-brand-500 selection:text-white overflow-x-hidden">

    <!-- Floating Background Shapes -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-[10%] left-[10%] w-[500px] h-[500px] bg-brand-600/20 rounded-full blur-3xl animate-blob opacity-50"></div>
        <div class="absolute bottom-[20%] right-[10%] w-[400px] h-[400px] bg-purple-600/20 rounded-full blur-3xl animate-blob animation-delay-2000 opacity-50"></div>
        <div class="absolute top-[40%] left-[40%] w-[600px] h-[600px] bg-indigo-600/10 rounded-full blur-3xl animate-blob animation-delay-4000 opacity-30"></div>
    </div>

    <!-- Main Content -->
    <div class="relative z-10">
        {{ $slot }}
    </div>

    <!-- Overlay Gradient -->
    <div class="fixed inset-0 bg-gradient-to-t from-black via-transparent to-black/20 pointer-events-none z-0"></div>

</body>
</html> 
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }} - Admin Access</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            [x-cloak] { display: none !important; }
            body { 
                font-family: 'Plus Jakarta Sans', sans-serif;
                margin: 0;
                padding: 0;
                background-image: url('{{ asset('images/auth-bg.jpg') }}');
                background-size: cover;
                background-position: center;
                background-attachment: fixed;
                background-repeat: no-repeat;
            }
            .auth-overlay {
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 24px;
                background-color: rgba(2, 6, 23, 0.45);
                backdrop-filter: blur(4px);
            }
            .auth-card {
                width: 100%;
                max-width: 460px;
                background: rgba(255, 255, 255, 0.98);
                border-radius: 40px;
                box-shadow: 0 40px 100px -20px rgba(0, 0, 0, 0.4);
                border: 1px solid rgba(255, 255, 255, 0.2);
                padding: 48px;
                position: relative;
                overflow: hidden;
                box-sizing: border-box;
                animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) both;
            }

            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .animate-delay-1 { animation-delay: 0.1s; }
            .animate-delay-2 { animation-delay: 0.2s; }
            .animate-delay-3 { animation-delay: 0.3s; }
            .animate-delay-4 { animation-delay: 0.4s; }
            .animate-delay-5 { animation-delay: 0.5s; }
            
            .fade-in-item {
                animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) both;
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="auth-overlay">
            {{ $slot }}
        </div>
    </body>
</html>

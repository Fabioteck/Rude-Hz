<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Rude-Hz') }}</title>

        <link rel="preconnect" href="https://bunny.net">
        <link href="https://bunny.net/css?family=figtree:400,900&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-[#0a0a0a] text-gray-200">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            
            <!-- Logo RUDE-HZ Gigante -->
            <div class="mb-10 text-center">
                <a href="/" class="flex flex-col items-center">
                    <span class="text-7xl md:text-8xl font-black text-[#d9ff00] tracking-tighter italic select-none leading-none">
                        RUDE-HZ
                    </span>
                    <span class="text-xs uppercase tracking-[0.5em] text-[#d9ff00]/50 font-bold mt-2">
                        Console System
                    </span>
                </a>
            </div>

            <!-- Card Contenitore -->
            <div class="w-full sm:max-w-md px-6 py-4 bg-transparent overflow-hidden">
                {{ $slot }}
            </div>

            <!-- Footer con testo Bianco Splendente -->
            <div class="mt-12 text-[10px] font-bold text-white uppercase tracking-[0.3em] opacity-100 text-center leading-loose">
                &copy; {{ date('Y') }} RUDE-HZ COMMUNITY
            </div>
        </div>
    </body>
</html>

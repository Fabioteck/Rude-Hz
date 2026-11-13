<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Rude-Hz') }}</title>
        <link rel="manifest" href="/manifest.json">
        <meta name="theme-color" content="#d9ff00">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

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
            <div class="mt-12 flex flex-col items-center gap-4">
                <div class="flex items-center gap-2">
                    <a href="{{ route('lang.switch', 'it') }}" title="Italiano" class="transition transform hover:scale-110">
                        <svg class="w-6 h-4 rounded-sm overflow-hidden border {{ app()->getLocale() == 'it' ? 'border-[#00FF66] shadow-[0_0_10px_rgba(0,255,102,0.8)]' : 'border-white/20 opacity-60 hover:opacity-100' }}" viewBox="0 0 3 2">
                            <rect width="1" height="2" fill="#008C45"/>
                            <rect x="1" width="1" height="2" fill="#F4F5F0"/>
                            <rect x="2" width="1" height="2" fill="#CD212A"/>
                        </svg>
                    </a>
                    <a href="{{ route('lang.switch', 'en') }}" title="English" class="transition transform hover:scale-110">
                        <svg class="w-6 h-4 rounded-sm overflow-hidden border {{ app()->getLocale() == 'en' ? 'border-[#00FF66] shadow-[0_0_10px_rgba(0,255,102,0.8)]' : 'border-white/20 opacity-60 hover:opacity-100' }}" viewBox="0 0 60 30">
                            <clipPath id="s-guest"><path d="M0,0 v30 h60 v-30 z"/></clipPath>
                            <clipPath id="t-guest"><path d="M30,15 h30 v15 z v-15 h-30 z h-30 v-15 z v15 h30 z"/></clipPath>
                            <g clip-path="url(#s-guest)">
                                <path d="M0,0 v30 h60 v-30 z" fill="#012169"/>
                                <path d="M0,0 L60,30 M60,0 L0,30" stroke="#fff" stroke-width="6"/>
                                <path d="M0,0 L60,30 M60,0 L0,30" clip-path="url(#t-guest)" stroke="#C8102E" stroke-width="4"/>
                                <path d="M30,0 v30 M0,15 h60" stroke="#fff" stroke-width="10"/>
                                <path d="M30,0 v30 M0,15 h60" stroke="#C8102E" stroke-width="6"/>
                            </g>
                        </svg>
                    </a>
                    <a href="{{ route('lang.switch', 'es') }}" title="Español" class="transition transform hover:scale-110">
                        <svg class="w-6 h-4 rounded-sm overflow-hidden border {{ app()->getLocale() == 'es' ? 'border-[#00FF66] shadow-[0_0_10px_rgba(0,255,102,0.8)]' : 'border-white/20 opacity-60 hover:opacity-100' }}" viewBox="0 0 750 500">
                            <rect width="750" height="500" fill="#aa151b"/>
                            <rect width="750" height="250" y="125" fill="#f1bf00"/>
                        </svg>
                    </a>
                </div>
                <div class="text-[10px] font-bold text-white uppercase tracking-[0.3em] opacity-100 text-center leading-loose">
                    &copy; {{ date('Y') }} RUDE-HZ COMMUNITY
                </div>
            </div>
        </div>

        <script>
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', () => {
                    navigator.serviceWorker.register('/sw.js').catch(err => console.log('SW registration failed: ', err));
                });
            }
        </script>
    </body>
</html>

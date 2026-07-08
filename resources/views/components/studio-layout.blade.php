<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'RUDE-HZ') }} | Studio</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-200 bg-[#0a0a0a]">
        
        <!-- Navigation Component -->
        <nav x-data="{ open: false }" class="border-b border-gray-800 bg-[#0a0a0a] relative z-[100]">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex justify-between h-16 items-center">
                    
                    <!-- Left: Logo -->
                    <div class="text-[#d9ff00] font-black uppercase tracking-[0.2em] text-xs md:text-base">
                        RUDE-HZ {{ Auth::user()->name }} | MY STUDIO
                    </div>
                    
                    <!-- Right: Hamburger -->
                    <button @click="open = ! open" class="text-gray-400 hover:text-[#d9ff00] focus:outline-none transition z-[101]">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Dropdown Menu (Optimized for Mobile) -->
            <div :class="{'block': open, 'hidden': ! open}" class="hidden fixed top-16 right-0 w-3/4 max-w-xs h-[calc(100vh-4rem)] bg-[#0a0a0a] z-[99] border-l border-gray-800 shadow-2xl">
                <div class="pt-8 space-y-2">
                    <a href="{{ route('user.studio') }}" class="block py-4 px-6 text-white hover:text-[#d9ff00] uppercase font-black text-sm tracking-[0.1em] text-right">MY STUDIO</a>
                    <a href="{{ route('user.tracks.index') }}" class="block py-4 px-6 text-white hover:text-[#d9ff00] uppercase font-black text-sm tracking-[0.1em] text-right">TRACCE</a>
                    <a href="{{ route('profile.liberatoria') }}" class="block py-4 px-6 text-white hover:text-[#d9ff00] uppercase font-black text-sm tracking-[0.1em] text-right">LIBERATORIA</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-right py-4 px-6 text-white hover:text-[#d9ff00] uppercase font-black text-sm tracking-[0.1em]">
                            LOGOUT
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <main>
            {{ $slot }}
        </main>
        
    </body>
</html>

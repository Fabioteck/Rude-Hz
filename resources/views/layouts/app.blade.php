<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-[#0a0a0a]">
        <div class="min-h-screen bg-[#0a0a0a]">
            @include('layouts.navigation')

            <!-- Page Heading ottimizzato per l'amministrazione mobile con Alpine.js -->
            @isset($header)
                <header class="bg-[#111111] border-b border-white/5 relative z-40" x-data="{ openAdminMenu: false }">
                    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex items-center justify-between">
                        
                        <!-- Titolo dinamico della sezione Admin (es. Dashboard, Contest, etc.) -->
                        <div class="font-black text-sm text-[#d9ff00] uppercase font-mono tracking-widest italic">
                            {{ $header }}
                        </div>

                        <!-- BOTTONE HAMBURGER CONSOLE (Visibile solo su smartphone) -->
                        <div class="flex md:hidden">
                            <button @click="openAdminMenu = !openAdminMenu" 
                                    type="button" 
                                    class="text-white hover:text-[#d9ff00] focus:outline-none p-2 relative z-50"
                                    aria-label="Apri menu admin">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path x-show="!openAdminMenu" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16" />
                                    <path x-show="openAdminMenu" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- PANNELLO SUB-MENU MOBILE ADMIN (Tendina scura coordinata) -->
                    <div x-show="openAdminMenu" 
                         x-cloak
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 -translate-y-2"
                         @click.away="openAdminMenu = false"
                         class="absolute top-full left-0 w-full bg-[#111111] border-b border-white/5 z-30 md:hidden font-mono text-xs uppercase font-bold italic tracking-widest">
                        
                        <div class="px-4 pt-2 pb-6 space-y-3 flex flex-col bg-gradient-to-b from-[#111111] to-[#0a0a0a]">
                            <a href="/admin" @click="openAdminMenu = false" class="text-white hover:text-[#d9ff00] transition py-2 border-b border-white/5 flex items-center justify-between">
                                <span>Dashboard Generale</span> <span>📊</span>
                            </a>
                            <a href="/admin/contest" @click="openAdminMenu = false" class="text-white hover:text-[#d9ff00] transition py-2 border-b border-white/5 flex items-center justify-between">
                                <span>Gestione Contest</span> <span>🏆</span>
                            </a>
                            <a href="/admin/news" @click="openAdminMenu = false" class="text-white hover:text-[#d9ff00] transition py-2 border-b border-white/5 flex items-center justify-between">
                                <span>Gestione News</span> <span>📰</span>
                            </a>
                            <a href="/admin/playlists" @click="openAdminMenu = false" class="text-white hover:text-[#d9ff00] transition py-2 border-b border-white/5 flex items-center justify-between">
                                <span>Gestione Playlist</span> <span>🎵</span>
                            </a>
                            <a href="/admin/artists" @click="openAdminMenu = false" class="text-white hover:text-[#d9ff00] transition py-2 border-b border-white/5 flex items-center justify-between">
                                <span>Modifica Artisti</span> <span>🎧</span>
                            </a>
                        </div>
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>

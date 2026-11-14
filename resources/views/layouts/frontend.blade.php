<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Rude-Hz - The Harder Side of Sound | Community Tekno & Underground')</title>
    <meta name="description" content="@yield('meta_description', 'Rude-Hz è la community underground e platform per producer di musica elettronica, tekno e sound system. Ascolta tracce, unisciti ai contest e scopri artisti.')">
    <link rel="canonical" href="@yield('canonical', url()->current())">

    <!-- Open Graph Tags -->
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="@yield('canonical', url()->current())">
    <meta property="og:title" content="@yield('title', 'Rude-Hz - The Harder Side of Sound | Community Tekno & Underground')">
    <meta property="og:description" content="@yield('meta_description', 'Rude-Hz è la community underground e platform per producer di musica elettronica, tekno e sound system. Ascolta tracce, unisciti ai contest e scopri artisti.')">
    <meta property="og:image" content="@yield('og_image', asset('images/logo_ruders.png'))">

    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#d9ff00">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="bg-[#0a0a0a] text-white">

    <!-- SFONDO VETTORIALE SPAZIALE CANVAS (60fps 80s Arcade) -->
    <canvas id="network-canvas" style="position: fixed; inset: 0; pointer-events: none; z-index: 15;"></canvas>

    <!-- NAVIGAZIONE RESPONSIVE STRUTTURATA (Stato inizializzato SOLO qui) -->
    <nav x-data="{ open: false }" class="sticky top-0 z-40 relative bg-[#0a0a0a]/80 backdrop-blur-md border-b border-white/10">
        <div class="max-w-7xl mx-auto px-4 h-20 flex justify-between items-center relative">
            
            <!-- LOGO -->
            <a href="{{ route('home') }}" wire:navigate class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-full border border-white/20 hover:border-[#E6FF00] overflow-hidden bg-[#0a0a0a] shrink-0 flex items-center justify-center transition-colors">
                    <img src="{{ asset('images/rudealien.jpeg') }}" alt="Rude-Hz Alien" class="w-full h-full object-cover">
                </div>
                <span class="text-2xl font-black text-[#d9ff00] uppercase italic tracking-tighter group-hover:text-white transition-colors">Rude-Hz</span>
            </a>
            
            <!-- LINK DESKTOP -->
            <div class="hidden md:flex space-x-8 uppercase text-xs tracking-widest font-bold font-mono italic">
                <a href="{{ route('project') }}" wire:navigate class="hover:text-[#d9ff00] transition {{ request()->routeIs('project') ? 'text-[#d9ff00]' : '' }}">{{ __('messages.menu.project') }}</a>
                <a href="{{ route('artists.index') }}" wire:navigate class="hover:text-[#d9ff00] transition {{ request()->routeIs('artists.*') ? 'text-[#d9ff00]' : '' }}">{{ __('messages.menu.artists') }}</a>
                <a href="{{ route('playlists.index') }}" wire:navigate class="hover:text-[#d9ff00] transition {{ request()->routeIs('playlists.*') ? 'text-[#d9ff00]' : '' }}">{{ __('messages.menu.playlists') }}</a>
                <a href="{{ route('tracks.index') }}" wire:navigate class="hover:text-[#d9ff00] transition {{ request()->routeIs('tracks.*') ? 'text-[#d9ff00]' : '' }}">{{ __('messages.menu.tracks') }}</a>
                <a href="{{ route('news.index') }}" wire:navigate class="hover:text-[#d9ff00] transition {{ request()->routeIs('news.*') ? 'text-[#d9ff00]' : '' }}">{{ __('messages.menu.news') }}</a>
                <a href="{{ route('support') }}" wire:navigate class="hover:text-[#d9ff00] transition {{ request()->routeIs('support') ? 'text-[#d9ff00]' : '' }}">SUPPORT</a>
            </div>

            <!-- BOTTONE UTENTE DESKTOP & BANDIERE SVG -->
            <div class="hidden md:flex items-center gap-6">
                <!-- BANDIERE SVG -->
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
                            <clipPath id="s"><path d="M0,0 v30 h60 v-30 z"/></clipPath>
                            <clipPath id="t"><path d="M30,15 h30 v15 z v-15 h-30 z h-30 v-15 z v15 h30 z"/></clipPath>
                            <g clip-path="url(#s)">
                                <path d="M0,0 v30 h60 v-30 z" fill="#012169"/>
                                <path d="M0,0 L60,30 M60,0 L0,30" stroke="#fff" stroke-width="6"/>
                                <path d="M0,0 L60,30 M60,0 L0,30" clip-path="url(#t)" stroke="#C8102E" stroke-width="4"/>
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

                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('dashboard') }}" wire:navigate class="text-xs font-mono font-bold text-[#d9ff00] hover:text-white transition uppercase italic border border-[#d9ff00]/30 px-4 py-2 rounded-md">
                            {{ Auth::user()->is_admin ? 'CONSOLE' : 'My Studio' }}
                        </a>
                    @else
                        <a href="{{ route('login') }}" wire:navigate class="text-xs font-mono uppercase italic font-bold text-white hover:text-[#d9ff00] transition">{{ __('messages.menu.login') }}</a>
                    @endauth
                @endif
            </div>

            <!-- BOTTONE HAMBURGER MOBILE -->
            <div class="flex md:hidden">
                <button @click="open = !open" 
                        type="button" 
                        class="text-white hover:text-[#d9ff00] focus:outline-none p-2 relative z-50 bg-transparent" 
                        aria-label="Toggle menu">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="open" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
        
        <!-- PANNELLO MOBILE INTEGRATO -->
        <div x-show="open" 
             x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             @click.away="open = false"
             class="absolute top-full left-0 w-full bg-[#121212] border-b border-white/10 z-40 md:hidden font-mono text-xs uppercase font-bold italic tracking-widest">
            
            <div class="px-6 pt-4 pb-6 space-y-4 flex flex-col bg-[#121212]">
                <a href="{{ route('project') }}" wire:navigate @click="open = false" class="py-2 border-b border-white/5 {{ request()->routeIs('project') ? 'text-[#d9ff00]' : 'text-white' }} hover:text-[#d9ff00]">PROGETTO</a>
                <a href="{{ route('artists.index') }}" wire:navigate @click="open = false" class="py-2 border-b border-white/5 {{ request()->routeIs('artists.*') ? 'text-[#d9ff00]' : 'text-white' }} hover:text-[#d9ff00]">ARTISTI</a>
                <a href="{{ route('playlists.index') }}" wire:navigate @click="open = false" class="py-2 border-b border-white/5 {{ request()->routeIs('playlists.*') ? 'text-[#d9ff00]' : 'text-white' }} hover:text-[#d9ff00]">PLAYLIST</a>
                <a href="{{ route('tracks.index') }}" wire:navigate @click="open = false" class="py-2 border-b border-white/5 {{ request()->routeIs('tracks.*') ? 'text-[#d9ff00]' : 'text-white' }} hover:text-[#d9ff00]">TRACCE</a>
                <a href="{{ route('news.index') }}" wire:navigate @click="open = false" class="py-2 border-b border-white/5 {{ request()->routeIs('news.*') ? 'text-[#d9ff00]' : 'text-white' }} hover:text-[#d9ff00]">NEWS</a>
                <a href="{{ route('support') }}" wire:navigate @click="open = false" class="py-2 border-b border-white/5 {{ request()->routeIs('support') ? 'text-[#d9ff00]' : 'text-white' }} hover:text-[#d9ff00]">SUPPORT</a>
                
                <div class="pt-4 flex flex-col gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}" wire:navigate @click="open = false" class="text-black bg-[#E6FF00] py-3 px-4 rounded text-center font-black transition hover:bg-white">
                            {{ Auth::user()->is_admin ? 'CONSOLE ADMIN' : 'MY STUDIO' }} ⚡
                        </a>
                    @else
                        <div class="grid grid-cols-2 gap-3 pt-2">
                            <a href="{{ route('login') }}" wire:navigate @click="open = false" class="text-center py-3 bg-zinc-900 border border-white/20 text-white rounded font-black hover:border-[#E6FF00] hover:text-[#E6FF00] transition">ACCEDI</a>
                            <a href="{{ route('register') }}" wire:navigate @click="open = false" class="text-center py-3 bg-[#E6FF00] text-black rounded font-black hover:bg-white transition">REGISTRATI</a>
                        </div>
                    @endauth

                    <div class="pt-4 border-t border-white/10 flex items-center justify-between">
                        <span class="text-zinc-500 text-[10px]">LINGUA / LANGUAGE</span>
                        <div class="flex items-center gap-3">
                            <a href="{{ route('lang.switch', 'it') }}" title="Italiano">
                                <svg class="w-6 h-4 rounded-sm overflow-hidden border {{ app()->getLocale() == 'it' ? 'border-[#00FF66]' : 'border-white/20 opacity-60' }}" viewBox="0 0 3 2">
                                    <rect width="1" height="2" fill="#008C45"/><rect x="1" width="1" height="2" fill="#F4F5F0"/><rect x="2" width="1" height="2" fill="#CD212A"/>
                                </svg>
                            </a>
                            <a href="{{ route('lang.switch', 'en') }}" title="English">
                                <svg class="w-6 h-4 rounded-sm overflow-hidden border {{ app()->getLocale() == 'en' ? 'border-[#00FF66]' : 'border-white/20 opacity-60' }}" viewBox="0 0 60 30">
                                    <rect width="60" height="30" fill="#012169"/><path d="M0,0 L60,30 M60,0 L0,30" stroke="#fff" stroke-width="6"/><path d="M30,0 v30 M0,15 h60" stroke="#fff" stroke-width="10"/>
                                </svg>
                            </a>
                            <a href="{{ route('lang.switch', 'es') }}" title="Español">
                                <svg class="w-6 h-4 rounded-sm overflow-hidden border {{ app()->getLocale() == 'es' ? 'border-[#00FF66]' : 'border-white/20 opacity-60' }}" viewBox="0 0 750 500">
                                    <rect width="750" height="500" fill="#aa151b"/><rect width="750" height="250" y="125" fill="#f1bf00"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- PUNTO DI INIEZIONE DEL CONTENUTO -->
    <main class="relative z-20 pb-24">
        @yield('content')
    </main>

    <!-- LIVEWIRE PLAYER PERSISTENTE GLOBALE -->
    @persist('rude-global-player')
        @livewire('player')
    @endpersist

</body>
</html>

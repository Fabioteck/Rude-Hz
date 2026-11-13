<div x-data="{ open: false }" class="relative w-full">
    <nav class="bg-black py-6 px-4 sm:px-8 border-b border-white/5 relative z-50 w-full">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            
            <!-- LOGO ACIDO -->
            <div class="flex items-center">
                <a href="/" class="text-2xl font-black tracking-tighter text-[#d9ff00] uppercase italic">Rude-Hz.it</a>
            </div>

            <!-- LINK DESKTOP (MD:FLEX) -->
            <div class="hidden md:flex items-center space-x-8 text-xs font-bold uppercase font-mono tracking-widest italic">
                <a href="/project" class="text-white hover:text-[#d9ff00] transition">Project</a>
                <a href="/artists" class="text-white hover:text-[#d9ff00] transition">Artists</a>                    
                <a href="/playlists" class="text-white hover:text-[#d9ff00] transition">Playlist</a>
                <a href="/tracks" class="text-white hover:text-[#d9ff00] transition">Tracks</a>
                <a href="/news" class="text-white hover:text-[#d9ff00] transition">News</a>
                
                @auth
                    <a href="/console" class="text-[#d9ff00] hover:text-white transition">Console</a>
                    <a href="/admin" class="text-zinc-400 hover:text-[#d9ff00] transition">Studio</a>
                @else
                    <a href="/login" class="text-white hover:text-[#d9ff00] transition">Login</a>
                @endauth
            </div>

            <!-- BOTTONE HAMBURGER (FORZATO SU MOBILE CON FLEX MD:HIDDEN) -->
            <div class="flex md:hidden">
                <button @click="open = !open" 
                        type="button" 
                        class="text-white hover:text-[#d9ff00] focus:outline-none p-2 relative z-50" 
                        aria-label="Toggle menu">
                    <!-- Icona Hamburger nativa -->
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="open" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
    </nav>

    <!-- PANNELLO MENU MOBILE A SCOMPARSA -->
    <div x-show="open" 
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         @click.away="open = false"
         class="absolute top-full left-0 w-full bg-black border-b border-white/5 z-40 md:hidden font-mono text-sm uppercase font-bold italic tracking-widest">
        
        <div class="px-4 pt-4 pb-6 space-y-4 flex flex-col bg-gradient-to-b from-black to-[#0a0a0a]">
            <a href="/project" @click="open = false" class="text-white hover:text-[#d9ff00] transition py-2 border-b border-white/5">Project</a>
            <a href="/playlists" @click="open = false" class="text-white hover:text-[#d9ff00] transition py-2 border-b border-white/5">Playlist</a>
            <a href="/news" @click="open = false" class="text-white hover:text-[#d9ff00] transition py-2 border-b border-white/5">News</a>
            <a href="/artists" @click="open = false" class="text-white hover:text-[#d9ff00] transition py-2 border-b border-white/5">Artists</a>
            <a href="/tracks" @click="open = false" class="text-white hover:text-[#d9ff00] transition py-2 border-b border-white/5">Tracks</a>
            
            @auth
                <!-- Se l'utente è autenticato -->
                <a href="/console" @click="open = false" class="text-[#d9ff00] hover:text-white transition pt-3 flex items-center justify-between border-t border-white/5">
                    <span>Console</span>
                    <span class="text-xs">⚡</span>
                </a>
                <a href="/admin" @click="open = false" class="text-zinc-400 hover:text-[#d9ff00] transition pt-2 flex items-center justify-between">
                    <span>Studio</span>
                    <span class="text-xs">⚙</span>
                </a>
            @else
                <!-- Se l'utente è un ospite anonimo -->
                <a href="/login" @click="open = false" class="text-white hover:text-[#d9ff00] transition pt-3 flex items-center justify-between border-t border-white/5">
                    <span>Login</span>
                    <span>→</span>
                </a>
            @endauth
        </div>
    </div>
</div>

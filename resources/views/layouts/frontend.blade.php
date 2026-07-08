<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rude-Hz.it</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0a0a0a] text-white">

    <!-- NAVIGAZIONE -->
    <nav class="sticky top-0 z-50 bg-[#0a0a0a]/80 backdrop-blur-md border-b border-white/10">
        <div class="max-w-7xl mx-auto px-4 h-20 flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-2xl font-black text-[#d9ff00]">Rude-Hz.it</a>
            
            <div class="hidden md:flex space-x-8 uppercase text-xs tracking-widest font-bold">
                <a href="{{ route('project') }}" class="hover:text-[#d9ff00] transition {{ request()->routeIs('project') ? 'text-[#d9ff00]' : '' }}">PROJECT</a>
                <a href="{{ route('playlists.index') }}" class="hover:text-[#d9ff00] transition {{ request()->routeIs('playlists.*') ? 'text-[#d9ff00]' : '' }}">PLAYLIST</a>
                <a href="{{ route('news.index') }}" class="hover:text-[#d9ff00] transition {{ request()->routeIs('news.*') ? 'text-[#d9ff00]' : '' }}">NEWS</a>
                <a href="{{ route('artists.index') }}" class="hover:text-[#d9ff00] transition {{ request()->routeIs('artists.*') ? 'text-[#d9ff00]' : '' }}">ARTISTS</a>
                <a href="{{ route('tracks.index') }}" class="hover:text-[#d9ff00] transition {{ request()->routeIs('tracks.*') ? 'text-[#d9ff00]' : '' }}">TRACKS</a>
                <a href="{{ route('contests.index') }}" class="hover:text-[#d9ff00] transition {{ request()->routeIs('contests.*') ? 'text-[#d9ff00]' : '' }}">CONTEST</a>
            </div>

            <div>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-sm font-bold text-[#d9ff00] hover:text-white transition">
                            {{ Auth::user()->is_admin ? 'CONSOLE' : 'My Studio' }}
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold mr-4 text-white hover:text-[#d9ff00] transition">Login</a>
                        <a href="{{ route('register') }}" class="bg-[#d9ff00] text-black px-4 py-2 rounded-full text-sm font-bold hover:bg-white transition shadow-[0_0_15px_rgba(217,255,0,0.3)]">
                            Join Us
                        </a>
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- PUNTO DI INIEZIONE DEL CONTENUTO -->
    <main class="pb-24">
        @yield('content')
    </main>

    <!-- PLAYER GLOBALE (STILE SPOTIFY - VANILLA JS) -->
    <div id="global-player" class="fixed bottom-0 left-0 w-full bg-[#0a0a0a] border-t border-gray-800 p-4 z-50 hidden">
        <div class="max-w-7xl mx-auto flex items-center justify-between gap-6">
            <div class="w-1/3">
                <h4 id="player-title" class="text-white text-sm font-black uppercase tracking-tight"></h4>
                <p id="player-artist" class="text-[#d9ff00] text-[10px] uppercase tracking-widest font-mono"></p>
            </div>
            
            <div class="flex items-center gap-4">
                <button id="player-toggle" class="text-[#d9ff00] hover:text-white">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                </button>
            </div>

            <div class="w-1/3 text-right">
                <input type="range" id="player-volume" min="0" max="1" step="0.1" value="1" class="accent-[#d9ff00]">
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer class="bg-[#050505] py-12 border-t border-white/5">
        <div class="max-w-7xl mx-auto px-4 text-center text-gray-500 text-xs tracking-widest uppercase">
            &copy; {{ date('Y') }} <a href="https://www.rude-hz.it" class="text-[#d9ff00] hover:text-white transition"> Rude-Hz Community</a> - Developed by <a href="https://www.fabioteck.it" class="text-[#d9ff00] hover:text-white transition">FabioTeck</a>
        </div>
    </footer>

    @stack('scripts')
    <script>
        // Player nativo vaniglia
        const audioPlayer = new Audio();
        const playerUI = document.getElementById('global-player');
        const titleEl = document.getElementById('player-title');
        const artistEl = document.getElementById('player-artist');
        const toggleBtn = document.getElementById('player-toggle');

        window.playTrack = function(streamUrl, title, artist) {
            audioPlayer.src = streamUrl;
            titleEl.textContent = title;
            artistEl.textContent = artist;
            playerUI.classList.remove('hidden');
            audioPlayer.play();
        };

        toggleBtn.addEventListener('click', () => {
            if (audioPlayer.paused) {
                audioPlayer.play();
            } else {
                audioPlayer.pause();
            }
        });
    </script>
</body>
</html>

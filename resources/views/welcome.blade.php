<!DOCTYPE html>
<html lang="it" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rude-Hz | TeKno Community</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-[#0a0a0a] text-white">
    <!-- NAVIGAZIONE -->
    <nav class="sticky top-0 z-50 bg-[#0a0a0a]/80 backdrop-blur-md border-b border-white/10">
        <div class="max-w-7xl mx-auto px-4 h-20 flex justify-between items-center">
            <span class="text-2xl font-black text-[#d9ff00]">RUDE-HZ.it</span>
            <div class="hidden md:flex space-x-8 uppercase text-xs tracking-widest font-bold">
                <a href="#radio" class="hover:text-[#d9ff00]">Radio</a>
                <a href="#artisti" class="hover:text-[#d9ff00]">Artisti</a>
                <a href="#tracks" class="hover:text-[#d9ff00]">Tracce</a>
            </div>
            <div>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-bold text-[#d9ff00]">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold mr-4">Login</a>
                        <a href="{{ route('register') }}" class="bg-[#d9ff00] text-black px-4 py-2 rounded-full text-sm font-bold hover:bg-white transition">Join</a>
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="h-[70vh] flex items-center justify-center text-center px-4">
        <div>
            <h1 class="text-6xl md:text-8xl font-black uppercase tracking-tighter mb-4 leading-none">
                The Harder <br> <span class="text-[#d9ff00]">Side of Sound</span>
            </h1>
            <p class="text-gray-400 text-lg mb-8">La community techno nata dai social.</p>
            <div class="flex justify-center gap-4">
                <a href="#radio" class="bg-white text-black px-8 py-4 rounded-full font-bold uppercase tracking-widest hover:bg-[#d9ff00] transition">Ascolta</a>
            </div>
        </div>
    </section>

    @php 
        $latestTrack = $tracks->first(); 
    @endphp

    <!-- SEZIONE RADIO -->
    <section id="radio" class="py-12 bg-[#111111]">
        <div class="max-w-5xl mx-auto px-4">
            <div class="bg-black p-6 md:p-10 rounded-[3rem] border border-white/10 flex flex-col md:flex-row items-center gap-10 shadow-2xl shadow-[#d9ff00]/5">
                
                <div class="relative group">
                    <div id="disk-container" class="w-48 h-48 bg-gradient-to-tr from-zinc-800 to-zinc-900 rounded-full flex items-center justify-center border-4 border-white/5 shadow-inner overflow-hidden transition-transform duration-500">
                        <img id="current-track-image" 
                             src="{{ ($latestTrack && $latestTrack->artist && $latestTrack->artist->profile_image) ? Storage::url($latestTrack->artist->profile_image) : 'https://picsum.photos' }}" 
                             class="w-full h-full object-cover opacity-50 group-hover:opacity-80 transition duration-700">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-10 h-10 bg-[#0a0a0a] rounded-full border-2 border-white/10 shadow-xl"></div>
                        </div>
                    </div>
                </div>

                <div class="flex-1 text-center md:text-left">
                    <span class="inline-block px-3 py-1 bg-[#d9ff00]/10 text-[#d9ff00] rounded-full text-[10px] font-black uppercase tracking-[0.2em] mb-4">On Air Now</span>
                    
                    <h3 id="master-player-title" class="text-4xl md:text-5xl font-black mb-2 uppercase italic tracking-tighter leading-none text-white">
                        {{ $latestTrack->title ?? 'Web Radio Online' }}
                    </h3>
                    <p id="master-player-artist" class="text-xl text-gray-500 font-medium italic">
                        {{ ($latestTrack && $latestTrack->artist) ? $latestTrack->artist->name : 'Stay Tuned' }}
                    </p>
                    
                    <div class="mt-10 flex flex-col gap-4">
                        <div class="flex items-center gap-6">
                            <button id="master-play-btn" 
                                    class="w-20 h-20 bg-white text-black rounded-full flex items-center justify-center hover:bg-[#d9ff00] hover:scale-105 transition-all duration-300 shadow-xl shadow-white/5">
                                <svg id="play-icon" class="w-10 h-10 ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"></path></svg>
                                <svg id="pause-icon" class="hidden w-10 h-10" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"></path></svg>
                            </button>

                            <div class="flex-1 group">
                                <div class="flex justify-between text-[10px] font-mono text-gray-600 mb-2 uppercase tracking-widest">
                                    <span id="current-time">00:00</span>
                                    <span id="total-duration">00:00</span>
                                </div>
                                <div id="progress-container" class="h-1.5 bg-white/10 rounded-full cursor-pointer relative">
                                    <div id="progress-bar" class="absolute left-0 top-0 h-full w-0 bg-[#d9ff00] rounded-full shadow-[0_0_10px_#d9ff00]"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- PLAYER AUDIO NASCOSTO -->
    <audio id="main-audio-player" src="{{ $latestTrack ? Storage::url($latestTrack->file_path) : '' }}" preload="auto"></audio>

    <!-- SEZIONE ARTISTI -->
    <section id="artisti" class="py-20 max-w-7xl mx-auto px-4">
        <div class="mb-12">
            <h2 class="text-4xl font-black uppercase italic tracking-tighter">Top Artists</h2>
            <p class="text-[#d9ff00] uppercase tracking-widest text-xs mt-2 font-bold font-mono italic">I talenti della community</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            @foreach($artists as $artist)
            <div class="group cursor-pointer">
                <div class="aspect-square bg-[#171717] rounded-2xl mb-4 overflow-hidden border border-white/5 group-hover:border-[#d9ff00]/50 transition-all duration-500">
                    <img src="{{ $artist->profile_image ? Storage::url($artist->profile_image) : 'https://picsum.photos&random='.$artist->id }}" 
                        class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-110 transition duration-700" 
                        alt="{{ $artist->name }}">
                </div>
                <h4 class="font-bold text-xl uppercase tracking-tighter italic">{{ $artist->name }}</h4>
                <p class="text-sm text-gray-500 font-mono italic uppercase">{{ $artist->style ?? 'Techno' }}</p>
            </div>
            @endforeach
        </div>
    </section>

    <!-- SEZIONE TRACCE -->
    <section id="tracks" class="py-20 border-t border-white/5">
        <div class="max-w-5xl mx-auto px-4">
            <h2 class="text-2xl font-black uppercase mb-10 italic tracking-tight">Latest Drops</h2>
            
            <div class="space-y-2">
                @forelse($tracks as $track)
                <div class="flex items-center justify-between p-4 bg-[#111111] hover:bg-[#171717] rounded-xl border border-white/5 transition group">
                    <div class="flex items-center gap-4">
                        <button onclick="playTrack('{{ Storage::url($track->file_path) }}', '{{ $track->title }}', '{{ $track->artist->name }}')" 
                                class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center group-hover:bg-[#d9ff00] group-hover:text-black transition">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"></path></svg>
                        </button>
                        <div>
                            <h4 class="font-bold uppercase tracking-tight text-sm">{{ $track->title }}</h4>
                            <p class="text-[10px] text-gray-500 uppercase italic font-medium">{{ $track->artist->name ?? 'Unknown' }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                         <span class="text-xs font-mono text-zinc-600 uppercase">{{ $track->genre }}</span>
                    </div>
                </div>
                @empty
                <p class="text-zinc-700 italic">No tracks approved yet.</p>
                @endforelse
            </div>
        </div>
    </section>

    <footer class="py-10 border-t border-white/5 text-center text-gray-600 text-[10px] uppercase tracking-widest font-bold italic">
        &copy; {{ date('Y') }} RUDE-HZ.it | Born in WhatsApp. Raised in Techno.
    </footer>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const audio = document.getElementById('main-audio-player');
        const masterPlayBtn = document.getElementById('master-play-btn');
        const playIcon = document.getElementById('play-icon');
        const pauseIcon = document.getElementById('pause-icon');
        const progressBar = document.getElementById('progress-bar');
        const disk = document.getElementById('disk-container');
        
        // Setup iniziale: volume a palla e pronto al drop
        audio.volume = 1.0;

        // --- FUNZIONE TOGGLE (PLAY/PAUSA) ---
        function togglePlay() {
            if (audio.paused) {
                audio.play().then(() => {
                    playIcon.classList.add('hidden');
                    pauseIcon.classList.remove('hidden');
                    if(disk) disk.classList.add('animate-spin-slow');
                }).catch(e => {
                    console.log("Autoplay bloccato o errore: attendere interazione.");
                });
            } else {
                audio.pause();
                playIcon.classList.remove('hidden');
                pauseIcon.classList.add('hidden');
                if(disk) disk.classList.remove('animate-spin-slow');
            }
        }

        // --- FUNZIONE GLOBALE PER CAMBIARE TRACCIA ---
        window.playTrack = function(url, title, artist, image) {
            if (audio.src !== url && url !== '') {
                audio.pause();
                audio.src = url;
                audio.load();
                document.getElementById('master-player-title').innerText = title;
                document.getElementById('master-player-artist').innerText = artist;
                if(image && document.getElementById('current-track-image')) {
                    document.getElementById('current-track-image').src = image;
                }
            }
            togglePlay();
        }

        // --- LOGICA AUTOPLAY "ZIO" ---
        // 1. Proviamo a farlo partire subito
        togglePlay();

        // 2. Se il browser lo blocca, lo facciamo partire al PRIMO click dell'utente sulla pagina
        const forceStart = () => {
            if (audio.paused) {
                togglePlay();
                console.log("Autoplay sbloccato dal click!");
            }
            document.removeEventListener('click', forceStart);
        };
        document.addEventListener('click', forceStart);

        // --- CONTROLLI E TIMER ---
        masterPlayBtn.addEventListener('click', (e) => {
            e.stopPropagation(); // Evita conflitti con l'evento click globale
            togglePlay();
        });

        audio.addEventListener('timeupdate', () => {
            if (audio.duration && !isNaN(audio.duration)) {
                const percent = (audio.currentTime / audio.duration) * 100;
                progressBar.style.width = percent + '%';
                document.getElementById('current-time').innerText = formatTime(audio.currentTime);
                document.getElementById('total-duration').innerText = formatTime(audio.duration);
            }
        });

        function formatTime(seconds) {
            if (isNaN(seconds) || seconds === Infinity) return "00:00";
            const min = Math.floor(seconds / 60);
            const sec = Math.floor(seconds % 60);
            return `${min < 10 ? '0' : ''}${min}:${sec < 10 ? '0' : ''}${sec}`;
        }
    });
</script>


    <style>
        @keyframes spin-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .animate-spin-slow {
            animation: spin-slow 10s linear infinite;
        }
    </style>
</body>
</html>

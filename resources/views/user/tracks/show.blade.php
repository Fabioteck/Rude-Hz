@extends('layouts.frontend')

@section('content')
<!-- SFONDO NEURONALE ESTESO A TUTTA LA PAGINA -->
<canvas id="network-canvas" class="fixed inset-0 w-full h-full z-0 opacity-30 pointer-events-none"></canvas>

<div class="relative z-10 w-full bg-zinc-950 min-h-screen text-white pt-16 pb-24">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        
        <!-- LINK DI RITORNO UNDERGROUND -->
        <div class="mb-12">
            <a href="{{ route('tracks.index') }}" class="text-xs font-bold text-zinc-500 uppercase tracking-widest font-mono italic hover:text-[#d9ff00] transition-colors flex items-center gap-2 group">
                <span class="transition-transform group-hover:-translate-x-1">←</span> Back to tracks archive
            </a>
        </div>

        <!-- BENTO CONTAINER PRINCIPALE -->
        <div class="bg-zinc-900/40 border border-white/5 rounded-md p-8 md:p-12 backdrop-blur-md">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-10 items-center">
                
                <!-- LATO SINISTRO: TITOLI, PLAYER CUSTOM E METADATI -->
                <div class="md:col-span-7 space-y-8">
                    <div>
                        <span class="px-2.5 py-0.5 bg-[#d9ff00]/10 border border-[#d9ff00]/30 text-[#d9ff00] text-[9px] font-mono uppercase font-bold rounded-sm inline-block mb-4">
                            Rude-Hz Drop
                        </span>
                        
                        <!-- TITOLO GIGANTE SANS BLACK ITALIC -->
                        <h1 class="text-5xl md:text-7xl font-black uppercase italic tracking-tighter text-white leading-[0.9] mb-3">
                            {{ $track->title }}
                        </h1>
                        
                        <p class="text-xl md:text-2xl text-zinc-400 uppercase font-bold tracking-widest font-mono">
                            {{ $track->artist->name ?? 'Unknown Artist' }}
                        </p>
                    </div>

                    <!-- CUSTOM AUDIO PLAYER MINIMALE -->
                    <div class="bg-zinc-900/80 border border-white/10 rounded-md p-5 backdrop-blur-md space-y-4 shadow-xl max-w-md">
                        <div class="flex items-center gap-4">
                            <button type="button" 
                                    id="custom-play-btn"
                                    onclick="toggleCustomPlay()"
                                    class="w-12 h-12 bg-[#d9ff00] text-black rounded-sm flex items-center justify-center font-black hover:bg-white transition shadow-sm shrink-0"
                                    title="Play / Pause">
                                <svg id="play-icon" class="w-5 h-5 ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                <svg id="pause-icon" class="w-5 h-5 hidden" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
                            </button>

                            <div class="flex-1 space-y-2">
                                <div class="flex justify-between text-[10px] font-mono text-zinc-400 uppercase">
                                    <span id="current-time">00:00</span>
                                    <span id="duration">00:00</span>
                                </div>
                                <div class="w-full bg-zinc-800 h-1.5 rounded-full overflow-hidden cursor-pointer" id="progress-container" onclick="seekAudio(event)">
                                    <div id="progress-bar" class="bg-[#d9ff00] h-full w-0 transition-all duration-100"></div>
                                </div>
                            </div>
                        </div>

                        <!-- TAG HTML AUDIO NASCOSTO -->
                        <audio id="track-audio-player" preload="metadata" class="hidden">
                            <source src="{{ asset('storage/' . $track->file_path) }}" type="audio/mpeg">
                        </audio>
                    </div>

                    <!-- METADATI GEOMETRICI ORIZZONTALI (GENRE, BPM, VERSION) -->
                    <div class="grid grid-cols-3 gap-4 pt-6 border-t border-white/5 font-mono">
                        <div class="bg-zinc-900/60 border border-white/5 p-3 rounded-sm">
                            <span class="block text-[9px] font-black text-zinc-500 uppercase tracking-widest mb-1">Genre</span>
                            <span class="text-xs font-bold uppercase text-[#d9ff00]">{{ $track->genre ?? 'TEKNO' }}</span>
                        </div>
                        <div class="bg-zinc-900/60 border border-white/5 p-3 rounded-sm">
                            <span class="block text-[9px] font-black text-zinc-500 uppercase tracking-widest mb-1">BPM</span>
                            <span class="text-xs font-bold uppercase text-white">{{ $track->bpm ?? '160' }}</span>
                        </div>
                        <div class="bg-zinc-900/60 border border-white/5 p-3 rounded-sm">
                            <span class="block text-[9px] font-black text-zinc-500 uppercase tracking-widest mb-1">Version</span>
                            <span class="text-xs font-bold uppercase text-white">{{ $track->version ?? 'Original' }}</span>
                        </div>
                    </div>
                </div>

                <!-- LATO DESTRO: QR CODE E CONDIVISIONE -->
                <div class="md:col-span-5 flex flex-col items-center justify-center space-y-8">
                    @if($track->qr_code_path)
                    <!-- BOX QR CODE GIALLO ACIDO COERENTE -->
                    <div class="bg-[#d9ff00] p-6 rounded-md shadow-[0_0_50px_rgba(217,255,0,0.15)] border border-[#d9ff00]">
                        <img src="{{ asset('storage/' . $track->qr_code_path) }}" class="w-48 h-48 mix-blend-multiply object-contain" alt="Track QR Code">
                    </div>
                    @endif

                    <div class="w-full max-w-xs space-y-2 font-mono text-xs">
                        <a href="https://wa.me/?text={{ urlencode(url()->current()) }}" target="_blank" 
                           class="block w-full py-3 bg-zinc-900/80 hover:bg-zinc-900 border border-white/10 rounded-sm text-center font-bold uppercase tracking-widest text-zinc-300 hover:text-[#d9ff00] transition">
                            Share on WhatsApp
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" 
                           class="block w-full py-3 bg-zinc-900/80 hover:bg-zinc-900 border border-white/10 rounded-sm text-center font-bold uppercase tracking-widest text-zinc-300 hover:text-[#d9ff00] transition">
                            Share on Facebook
                        </a>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<!-- SCRIPT CUSTOM AUDIO PLAYER & CANVAS NEURONALE -->
<script>
const audio = document.getElementById('track-audio-player');
const playBtn = document.getElementById('custom-play-btn');
const playIcon = document.getElementById('play-icon');
const pauseIcon = document.getElementById('pause-icon');
const progressBar = document.getElementById('progress-bar');
const currentTimeEl = document.getElementById('current-time');
const durationEl = document.getElementById('duration');

function formatTime(seconds) {
    const mins = Math.floor(seconds / 60);
    const secs = Math.floor(seconds % 60);
    return `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
}

if (audio) {
    audio.addEventListener('loadedmetadata', () => {
        durationEl.textContent = formatTime(audio.duration);
    });

    audio.addEventListener('timeupdate', () => {
        const progressPercent = (audio.currentTime / audio.duration) * 100;
        progressBar.style.width = `${progressPercent}%`;
        currentTimeEl.textContent = formatTime(audio.currentTime);
    });

    audio.addEventListener('ended', () => {
        playIcon.classList.remove('hidden');
        pauseIcon.classList.add('hidden');
    });
}

function toggleCustomPlay() {
    if (!audio) return;
    if (audio.paused) {
        audio.play();
        playIcon.classList.add('hidden');
        pauseIcon.classList.remove('hidden');
    } else {
        audio.pause();
        playIcon.classList.remove('hidden');
        pauseIcon.classList.add('hidden');
    }
}

function seekAudio(event) {
    if (!audio || !audio.duration) return;
    const container = document.getElementById('progress-container');
    const rect = container.getBoundingClientRect();
    const clickX = event.clientX - rect.left;
    const width = rect.width;
    const percent = clickX / width;
    audio.currentTime = percent * audio.duration;
}

// CANVAS NEURONALE OTTIMIZZATO PER RASPBERRY PI 4
const canvas = document.getElementById('network-canvas');
if (canvas) {
    const ctx = canvas.getContext('2d');

    let width, height;
    let particles = [];
    const connectionDist = 110;

    function resize() {
        width = canvas.width = window.innerWidth;
        height = canvas.height = window.innerHeight;
        
        const isMobile = width < 768;
        const count = isMobile ? 25 : Math.min(Math.floor((width * height) / 18000), 70);
        
        particles = [];
        for (let i = 0; i < count; i++) {
            particles.push(new Particle());
        }
    }

    class Particle {
        constructor() {
            this.init();
        }
        init() {
            this.x = Math.random() * width;
            this.y = Math.random() * height;
            this.vx = (Math.random() - 0.5) * 1.0;
            this.vy = (Math.random() - 0.5) * 1.0;
            this.size = Math.random() * 1.2 + 0.8;
        }
        update() {
            this.x += this.vx;
            this.y += this.vy;

            if (this.x < 0 || this.x > width) this.vx *= -1;
            if (this.y < 0 || this.y > height) this.vy *= -1;
        }
        draw() {
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
            ctx.fillStyle = '#d9ff00';
            ctx.fill();
        }
    }

    window.addEventListener('resize', resize);
    resize();

    function animate() {
        ctx.clearRect(0, 0, width, height);

        for (let i = 0; i < particles.length; i++) {
            particles[i].update();
            particles[i].draw();

            for (let j = i + 1; j < particles.length; j++) {
                const dx = particles[i].x - particles[j].x;
                const dy = particles[i].y - particles[j].y;
                const dist = Math.sqrt(dx * dx + dy * dy);

                if (dist < connectionDist) {
                    ctx.beginPath();
                    ctx.strokeStyle = `rgba(217, 255, 0, ${0.25 * (1 - dist / connectionDist)})`;
                    ctx.lineWidth = 0.5;
                    ctx.moveTo(particles[i].x, particles[i].y);
                    ctx.lineTo(particles[j].x, particles[j].y);
                    ctx.stroke();
                }
            }
        }
        requestAnimationFrame(animate);
    }
    animate();
}
</script>
@endsection

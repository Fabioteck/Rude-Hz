@extends('layouts.frontend')

@section('title', 'Playlist Ufficiali & Dj Set - Rude-Hz')
@section('meta_description', 'Ascolta le playlist ufficiali, i DJ set e le selezioni musicali curate dalla community underground Rude-Hz.')

@section('content')
<!-- SFONDO NEURONALE ESTESO A TUTTA LA PAGINA -->
<canvas id="network-canvas" class="fixed inset-0 w-full h-full z-0 opacity-40 pointer-events-none"></canvas>

<div class="relative z-10 w-full bg-zinc-950 min-h-screen text-white pt-16 pb-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        
        <!-- INTESTAZIONE MINIMALISTA -->
        <div class="mb-12 border-b border-white/10 pb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-5xl md:text-7xl font-black uppercase italic tracking-tighter text-white">
                    Playlists
                </h1>
                <p class="text-[#d9ff00] uppercase tracking-widest text-xs mt-3 font-bold font-mono italic">
                    [03] Dj set ufficiali & selezioni della community
                </p>
            </div>
            <div class="text-xs font-mono text-zinc-500 uppercase tracking-widest">
                TOTALE PLAYLIST: <span class="text-[#d9ff00] font-bold">{{ method_exists($playlists, 'total') ? $playlists->total() : $playlists->count() }}</span>
            </div>
        </div>

        <!-- GESTIONE STATO VUOTO (EMPTY STATE) -->
        @if($playlists->isEmpty())
            <div class="max-w-md mx-auto my-20 p-8 bg-zinc-900/40 border border-[#d9ff00]/30 rounded-md text-center backdrop-blur-md">
                <div class="w-12 h-12 mx-auto mb-4 rounded-full bg-[#d9ff00]/10 border border-[#d9ff00]/30 flex items-center justify-center text-[#d9ff00]">
                    💿
                </div>
                <h3 class="font-bold text-lg uppercase tracking-tight text-white mb-2">Rude Selection</h3>
                <p class="text-xs text-zinc-400 font-mono italic uppercase tracking-wider">
                    Nessuna playlist disponibile al momento.
                </p>
            </div>
        @else
            <!-- GRIGLIA COMPATTA STILE DECK / VINILE TECNICO -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($playlists as $playlist)
                <div class="group bg-zinc-900/40 hover:bg-zinc-900/80 border border-white/5 hover:border-[#d9ff00]/50 rounded-md p-5 transition-all duration-300 backdrop-blur-md flex flex-col justify-between">
                    <div>
                        <!-- HEADER CARD -->
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-[9px] text-[#d9ff00] font-mono uppercase font-bold border border-[#d9ff00]/30 px-2.5 py-0.5 rounded-sm bg-[#d9ff00]/5">
                                Playlist
                            </span>
                            <span class="text-[10px] text-zinc-500 font-mono italic uppercase">
                                {{ $playlist->created_at->diffForHumans() }}
                            </span>
                        </div>
                        
                        <!-- TITOLO -->
                        <h4 class="font-bold text-xl uppercase tracking-tighter italic text-white leading-tight group-hover:text-[#d9ff00] transition duration-200 line-clamp-1 mb-2">
                            {{ $playlist->title ?? $playlist->name }}
                        </h4>
                        
                        <!-- DESCRIZIONE -->
                        <p class="text-xs text-zinc-400 font-mono italic line-clamp-3 leading-relaxed">
                            {{ $playlist->description ?? 'Selezione musicale underground curata dalla community.' }}
                        </p>
                    </div>

                    <!-- FOOTER CARD -->
                    <div class="pt-4 mt-6 border-t border-white/5 flex items-center justify-between">
                        <span class="text-[11px] font-mono font-bold text-zinc-500 uppercase">
                            {{ $playlist->tracks_count ?? 0 }} Tracks
                        </span>
                        
                        <a href="{{ route('playlists.show', $playlist->slug ?? '') }}" 
                           class="inline-flex items-center justify-center w-8 h-8 bg-zinc-900 border border-white/20 text-white group-hover:bg-[#d9ff00] group-hover:text-black group-hover:border-[#d9ff00] transition-all rounded-sm shadow-sm"
                           title="Ascolta playlist">
                            →
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- PAGINAZIONE STILIZZATA -->
            @if(method_exists($playlists, 'links') && $playlists->hasPages())
            <div class="mt-16 flex justify-center">
                <div class="bg-zinc-900/60 border border-white/10 rounded-md p-3 backdrop-blur-md font-mono text-xs">
                    {{ $playlists->links() }}
                </div>
            </div>
            @endif
        @endif

    </div>
</div>

<!-- SCRIPT CANVAS NEURONALE OTTIMIZZATO PER RASPBERRY PI 4 -->
<script>
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

@extends('layouts.frontend')

@section('title', 'Rude-Hz - The Harder Side of Sound | Community Tekno & Underground')
@section('meta_description', 'Community underground e platform per producer di musica elettronica, tekno e sound system. Scopri le ultime tracce, news e artisti.')

@section('content')
<!-- HERO SECTION & NEURAL CANVAS -->
<section class="relative h-[80vh] min-h-[550px] flex items-center justify-center text-center px-4 overflow-hidden bg-zinc-950 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-zinc-900 via-zinc-950 to-zinc-950 border-b border-white/10">
    <canvas id="network-canvas" class="absolute inset-0 w-full h-full z-0 opacity-80 pointer-events-none"></canvas>
    
    <div class="relative z-10 max-w-5xl mx-auto space-y-6">
        <!-- BADGE / TAGLINE -->
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/[0.03] border border-white/10 text-xs font-mono uppercase tracking-widest text-[#d9ff00] backdrop-blur-md">
            <span class="w-2 h-2 rounded-full bg-[#d9ff00] animate-pulse"></span>
            Community Tekno & Underground Sound
        </div>

        <!-- TITOLO PRINCIPALE IN GIALLO ACIDO PURO SENZA BOX DI SFONDO -->
        <h1 class="text-4xl md:text-5xl font-black uppercase italic tracking-tighter leading-[1.1] text-[#d9ff00] drop-shadow-[0_10px_20px_rgba(0,0,0,0.8)]">
            The Harder <br class="hidden sm:inline"> Side of Sound
        </h1>

        <!-- CTA BUTTONS (DIRETTE CON AUTH/GUEST E ROTTE) -->
        <div class="flex flex-wrap items-center justify-center gap-3 pt-4">
            @guest
                <a href="{{ route('register') }}" 
                   class="px-6 py-3 bg-[#d9ff00] text-black font-black font-mono uppercase italic tracking-wider text-xs rounded-lg hover:bg-white transition-all duration-300 shadow-[0_0_20px_rgba(217,255,0,0.2)] hover:shadow-[0_0_30px_rgba(217,255,0,0.5)] transform hover:-translate-y-0.5">
                    ⚡ Registrati Gratis
                </a>
                <a href="{{ route('login') }}" 
                   class="px-6 py-3 bg-zinc-900/80 border border-white/10 text-white font-black font-mono uppercase italic tracking-wider text-xs rounded-lg hover:border-[#d9ff00] hover:text-[#d9ff00] transition-all duration-300 backdrop-blur-md">
                    Login Studio
                </a>
            @else
                <a href="{{ route('dashboard') }}" 
                   class="px-6 py-3 bg-[#d9ff00] text-black font-black font-mono uppercase italic tracking-wider text-xs rounded-lg hover:bg-white transition-all duration-300 shadow-[0_0_20px_rgba(217,255,0,0.2)] hover:shadow-[0_0_30px_rgba(217,255,0,0.5)]">
                    ⚡ {{ Auth::user()->is_admin ? 'Accedi alla Console' : 'Entra nel mio Studio' }}
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" 
                            class="px-5 py-3 bg-zinc-900/80 border border-red-500/30 text-red-400 font-mono uppercase italic tracking-wider text-xs rounded-lg hover:bg-red-500 hover:text-white transition-all duration-300">
                        Esci
                    </button>
                </form>
            @endguest

            <a href="{{ route('tracks.index') }}" 
               class="px-6 py-3 bg-transparent border border-white/20 text-white font-mono uppercase italic tracking-wider text-xs rounded-lg hover:bg-white/5 transition-all duration-300">
                Esplora Tracce
            </a>
        </div>
    </div>
</section>

<!-- BENTO GRID SECTION (BLOCCHI INVERTITI: NEWS & FEED PRIMA, LATEST DROPS DOPO) -->
<section class="py-24 bg-zinc-950 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- PRIMO BLOCCO (A SINISTRA / PREDOMINANTE): NEWS & FEED -->
            <div class="lg:col-span-2 space-y-6">
                <div class="flex items-center justify-between pb-4 border-b border-white/10">
                    <div>
                        <h2 class="text-2xl md:text-3xl font-black uppercase italic tracking-tighter">News & Feed</h2>
                        <p class="text-[10px] font-mono text-[#d9ff00] uppercase tracking-widest mt-1">Comunicazioni & articoli ufficiali</p>
                    </div>
                    <a href="{{ route('news.index') }}" class="text-xs font-mono text-zinc-400 hover:text-[#d9ff00] uppercase transition">Archivio →</a>
                </div>

                @if($latestNews)
                <div class="bg-zinc-900/40 border border-white/5 rounded-md p-6 backdrop-blur-md space-y-4 group">
                    @if($latestNews->image_path)
                    <div class="rounded-sm overflow-hidden border border-white/10 h-48 w-full">
                        <img src="{{ asset('storage/' . $latestNews->image_path) }}" alt="{{ $latestNews->title }}" loading="lazy" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition duration-500">
                    </div>
                    @endif
                    <div class="text-[10px] font-mono text-zinc-500 uppercase tracking-widest">
                        {{ $latestNews->created_at->format('d . m . Y') }}
                    </div>
                    <h3 class="font-black text-xl uppercase tracking-tight text-white group-hover:text-[#d9ff00] transition">
                        {{ $latestNews->title }}
                    </h3>
                    <p class="text-zinc-400 text-xs font-mono line-clamp-3 leading-relaxed">
                        {{ $latestNews->excerpt ?? Str::limit(strip_tags($latestNews->content), 120) }}
                    </p>
                    <a href="{{ route('news.show', $latestNews->slug) }}" class="inline-block text-[10px] font-mono uppercase tracking-widest text-[#d9ff00] hover:text-white transition pt-2">
                        Leggi articolo completo →
                    </a>
                </div>
                @endif

                <!-- LISTA ALTRE NEWS -->
                <div class="space-y-3">
                    @foreach($otherNews ?? [] as $article)
                    <a href="{{ route('news.show', $article->slug) }}" class="block p-4 bg-zinc-900/40 hover:bg-zinc-900/80 border border-white/5 rounded-md transition group backdrop-blur-md">
                        <div class="text-[9px] font-mono text-zinc-500 uppercase tracking-widest mb-1">
                            {{ $article->created_at->format('d . m . Y') }}
                        </div>
                        <h4 class="font-bold text-sm uppercase tracking-tight text-white group-hover:text-[#d9ff00] transition line-clamp-2">
                            {{ $article->title }}
                        </h4>
                    </a>
                    @endforeach
                </div>
            </div>

            <!-- SECONDO BLOCCO (A DESTRA): LATEST DROPS -->
            <div class="space-y-6">
                <div class="flex items-center justify-between pb-4 border-b border-white/10">
                    <div>
                        <h2 class="text-2xl md:text-3xl font-black uppercase italic tracking-tighter">Latest Drops</h2>
                        <p class="text-[10px] font-mono text-[#d9ff00] uppercase tracking-widest mt-1">Ultime tracce in rotazione</p>
                    </div>
                    <a href="{{ route('tracks.index') }}" class="text-xs font-mono text-zinc-400 hover:text-[#d9ff00] uppercase transition">Vedi tutte →</a>
                </div>

                <div class="space-y-3">
                    @forelse($tracks->take(6) as $track)
                    <div class="flex items-center justify-between p-4 bg-zinc-900/40 hover:bg-zinc-900/80 border border-white/5 rounded-md transition-all duration-200 group backdrop-blur-md">
                        <div class="flex items-center gap-4 truncate">
                            <button onclick="Livewire.dispatch('playTrack', { trackId: {{ $track->id }} })" 
                                    class="w-10 h-10 rounded-sm bg-zinc-800 border border-white/10 flex items-center justify-center group-hover:bg-[#d9ff00] group-hover:text-black group-hover:border-[#d9ff00] transition shrink-0"
                                    title="Play track">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                            </button>
                            <div class="truncate">
                                <a href="{{ route('track.public.show', $track->slug) }}" class="font-bold uppercase tracking-tight text-sm text-white group-hover:text-[#d9ff00] transition truncate block">
                                    {{ $track->title }}
                                </a>
                                <p class="text-[10px] text-[#d9ff00] uppercase italic font-mono mt-0.5 truncate font-semibold">
                                    {{ $track->artist->name ?? 'Unknown Artist' }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 shrink-0 font-mono text-xs">
                            <span class="px-2 py-1 bg-white/5 border border-white/10 rounded-sm text-[10px] text-[#d9ff00] uppercase">
                                {{ $track->genre ?? 'TEKNO' }}
                            </span>
                            <a href="{{ route('track.public.show', $track->slug) }}" class="text-zinc-500 hover:text-white transition">→</a>
                        </div>
                    </div>
                    @empty
                    <div class="p-12 text-center bg-zinc-900/40 border border-white/5 rounded-md">
                        <p class="text-zinc-600 italic font-mono uppercase text-xs">Nessuna traccia disponibile al momento.</p>
                    </div>
                    @endforelse
                </div>
            </div>

        </div>

    </div>
</section>

<!-- SCRIPT CANVAS NEURONALE OTTIMIZZATO PER RASPBERRY PI 4 -->
<script>
// NEURAL NETWORK CANVAS ANIMATION (OPTIMIZED FOR RASPBERRY PI 4 CPU)
const canvas = document.getElementById('network-canvas');
if (canvas) {
    const ctx = canvas.getContext('2d');

    let width, height;
    let particles = [];
    const connectionDist = 110;
    let mouse = { x: null, y: null, radius: 150 };

    window.addEventListener('mousemove', (e) => {
        const rect = canvas.getBoundingClientRect();
        mouse.x = e.clientX - rect.left;
        mouse.y = e.clientY - rect.top;
    });

    window.addEventListener('mouseleave', () => {
        mouse.x = null;
        mouse.y = null;
    });

    function resize() {
        width = canvas.width = canvas.parentElement.offsetWidth;
        height = canvas.height = canvas.parentElement.offsetHeight;
        
        // Scaling dinamico dei nodi in base alla risoluzione (leggero su Raspberry Pi 4)
        const isMobile = width < 768;
        const count = isMobile ? 30 : Math.min(Math.floor((width * height) / 14000), 90);
        
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
            this.vx = (Math.random() - 0.5) * 1.2;
            this.vy = (Math.random() - 0.5) * 1.2;
            this.size = Math.random() * 1.5 + 1;
        }
        update() {
            this.x += this.vx;
            this.y += this.vy;

            if (this.x < 0 || this.x > width) this.vx *= -1;
            if (this.y < 0 || this.y > height) this.vy *= -1;

            if (mouse.x !== null && mouse.y !== null) {
                const dx = mouse.x - this.x;
                const dy = mouse.y - this.y;
                const dist = Math.sqrt(dx * dx + dy * dy);
                if (dist < mouse.radius) {
                    const angle = Math.atan2(dy, dx);
                    this.x -= Math.cos(angle) * 0.8;
                    this.y -= Math.sin(angle) * 0.8;
                }
            }
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
                    ctx.strokeStyle = `rgba(217, 255, 0, ${0.3 * (1 - dist / connectionDist)})`;
                    ctx.lineWidth = 0.75;
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

<!-- SISTEMA DI TRACCIAMENTO TEMPO DI PERMANENZA E METADATI (ANALYTICS) -->
@if(session('last_analytics_id'))
<meta name="analytics-id" content="{{ session('last_analytics_id') }}">
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const analyticsId = document.querySelector('meta[name="analytics-id"]')?.getAttribute('content');
        if (!analyticsId) return;

        const pingInterval = 15; // 15 secondi
        const apiUrl = "/api/analytics/metadata";
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        setInterval(() => {
            fetch(apiUrl, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": token
                },
                body: JSON.stringify({
                    analytics_id: analyticsId,
                    ping: true
                })
            }).catch(err => console.log('Analytics bypass:', err));
        }, pingInterval * 1000);
    });
</script>
@endif
@endsection

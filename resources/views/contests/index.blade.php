@extends('layouts.frontend')

@section('title', 'Contest & Remix Challenges - Rude-Hz')
@section('meta_description', 'Partecipa ai contest di produzione musicale, remix challenges e arene creative della community Rude-Hz.')

@section('content')
<!-- SFONDO NEURONALE ESTESO A TUTTA LA PAGINA -->
<canvas id="network-canvas" class="fixed inset-0 w-full h-full z-0 opacity-40 pointer-events-none"></canvas>

<div class="relative z-10 w-full bg-zinc-950 min-h-screen text-white pt-16 pb-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        
        <!-- INTESTAZIONE MINIMALISTA -->
        <div class="mb-12 border-b border-white/10 pb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-5xl md:text-7xl font-black uppercase italic tracking-tighter text-white">
                    Contests
                </h1>
                <p class="text-[#d9ff00] uppercase tracking-widest text-xs mt-3 font-bold font-mono italic">
                    [05] Arena generative producers & remix challenges
                </p>
            </div>
            <div class="text-xs font-mono text-zinc-500 uppercase tracking-widest">
                CONTEST ATTIVI: <span class="text-[#d9ff00] font-bold">{{ $contests->count() }}</span>
            </div>
        </div>

        <!-- GRIGLIA CONTEST O EMPTY STATE -->
        @if($contests->isEmpty())
            <div class="max-w-md mx-auto my-20 p-8 bg-zinc-900/40 border border-[#d9ff00]/30 rounded-md text-center backdrop-blur-md">
                <div class="w-12 h-12 mx-auto mb-4 rounded-full bg-[#d9ff00]/10 border border-[#d9ff00]/30 flex items-center justify-center text-[#d9ff00]">
                    ⚡
                </div>
                <h3 class="font-bold text-lg uppercase tracking-tight text-white mb-2">Arena Chiusa</h3>
                <p class="text-xs text-zinc-400 font-mono italic uppercase tracking-wider leading-relaxed">
                    Nessun contest attivo in questo momento. Preparati per la prossima sessione.
                </p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($contests as $contest)
                <div class="group bg-zinc-900/40 hover:bg-zinc-900/80 border border-white/5 hover:border-[#d9ff00]/50 rounded-md overflow-hidden transition-all duration-300 backdrop-blur-md flex flex-col justify-between">
                    
                    @if($contest->image_path)
                    <div class="relative w-full aspect-video overflow-hidden border-b border-white/5">
                        <img src="{{ asset('storage/' . $contest->image_path) }}" alt="{{ $contest->title }}" loading="lazy" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition duration-500">
                    </div>
                    @endif

                    <div class="p-6 flex flex-col justify-between flex-grow space-y-4">
                        <div>
                            <!-- BADGE DI STATO -->
                            <div class="flex justify-between items-center mb-3">
                                <span class="px-2.5 py-0.5 bg-[#d9ff00]/10 border border-[#d9ff00]/30 text-[#d9ff00] text-[9px] font-mono uppercase font-bold rounded-sm">
                                    {{ $contest->is_active ? 'Aperto / Active' : 'Chiuso / Closed' }}
                                </span>
                                <span class="text-[10px] font-mono text-zinc-500 uppercase">
                                    Max {{ $contest->max_tracks_per_artist ?? 1 }} tracks/artist
                                </span>
                            </div>

                            <h2 class="text-2xl font-black uppercase italic tracking-tighter text-white group-hover:text-[#d9ff00] transition-colors mb-2">
                                {{ $contest->title }}
                            </h2>

                            <div class="text-zinc-400 text-xs font-mono line-clamp-3 leading-relaxed">
                                {{ strip_tags($contest->description) }}
                            </div>
                        </div>

                        <!-- METADATI E AZIONE -->
                        <div class="pt-4 border-t border-white/5 flex items-center justify-between text-xs font-mono">
                            <span class="text-zinc-500 uppercase">
                                Scadenza: {{ \Carbon\Carbon::parse($contest->end_date ?? now())->format('d . m . Y') }}
                            </span>

                            <a href="{{ route('contests.show', $contest->slug) }}" 
                               class="inline-flex items-center gap-2 px-4 py-2 bg-zinc-900 border border-white/20 text-white font-mono uppercase italic tracking-wider text-xs rounded-sm group-hover:bg-[#d9ff00] group-hover:text-black group-hover:border-[#d9ff00] transition-all">
                                <span>Partecipa</span>
                                <span class="transition-transform group-hover:translate-x-1">→</span>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
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

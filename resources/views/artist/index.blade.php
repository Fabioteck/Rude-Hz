@extends('layouts.frontend')

@section('content')
<!-- SFONDO NEURONALE ESTESO A TUTTA LA PAGINA -->
<canvas id="network-canvas" class="fixed inset-0 w-full h-full z-0 opacity-40 pointer-events-none"></canvas>

<div class="relative z-10 w-full bg-zinc-950 min-h-screen text-white pt-16 pb-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        
        <!-- INTESTAZIONE MINIMALISTA -->
        <div class="mb-12 border-b border-white/10 pb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-5xl md:text-7xl font-black uppercase italic tracking-tighter text-white">
                    Artists
                </h1>
                <p class="text-[#d9ff00] uppercase tracking-widest text-xs mt-3 font-bold font-mono italic">
                    [02] I talenti della community & producers underground
                </p>
            </div>
            <div class="text-xs font-mono text-zinc-500 uppercase tracking-widest">
                TOTALE ARTISTI: <span class="text-[#d9ff00] font-bold">{{ $artists->total() ?? $artists->count() }}</span>
            </div>
        </div>

        <!-- GRIGLIA ARTISTI COMPATTA (RIDUZIONE 30% / GRIGLIA DENSA) -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 sm:gap-6">
            @forelse($artists as $artist)
            <div class="group cursor-pointer">
                <a href="{{ route('artists.show', $artist->slug) }}" class="block p-3 bg-zinc-900/40 hover:bg-zinc-900/80 border border-white/5 hover:border-[#d9ff00]/50 rounded-md transition-all duration-300 backdrop-blur-md">
                    
                    <!-- BOX IMMAGINE COMPATTO -->
                    <div class="aspect-square bg-zinc-900 rounded-sm mb-3 overflow-hidden border border-white/5 relative">
                        @if($artist->profile_image)
                            <img src="{{ Storage::url($artist->profile_image) }}" 
                                 loading="lazy" 
                                 class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-105 transition duration-500 absolute inset-0" 
                                 alt="{{ $artist->name }}">
                        @else
                            <img src="{{ \App\Services\ImageOptimizerService::placeholderUrl() }}" class="w-full h-full object-cover absolute inset-0 grayscale group-hover:grayscale-0 group-hover:scale-105 transition duration-500" alt="Placeholder">
                        @endif
                    </div>

                    <!-- TESTI COMPATTI -->
                    <h4 class="font-bold text-sm uppercase tracking-tight text-white leading-tight group-hover:text-[#d9ff00] transition duration-200 truncate">
                        {{ $artist->name }}
                    </h4>
                    <p class="text-[10px] text-zinc-400 font-mono italic uppercase mt-1 truncate">
                        {{ $artist->style ?? 'Tekno' }}
                    </p>
                </a>
            </div>
            @empty
            <div class="col-span-full py-16 text-center text-zinc-600 italic uppercase font-mono">
                Nessun artista registrato al momento.
            </div>
            @endforelse
        </div>

        <!-- PAGINAZIONE STILIZZATA -->
        @if(method_exists($artists, 'links') && $artists->hasPages())
        <div class="mt-16 flex justify-center">
            <div class="bg-zinc-900/60 border border-white/10 rounded-md p-3 backdrop-blur-md font-mono text-xs">
                {{ $artists->links() }}
            </div>
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

@extends('layouts.frontend')

@section('title', 'News & Feed Ufficiali - Rude-Hz')
@section('meta_description', 'Leggi gli ultimi articoli, comunicazioni ufficiali e approfondimenti dal mondo underground di Rude-Hz.')

@section('content')
<!-- SFONDO NEURONALE ESTESO A TUTTA LA PAGINA -->
<canvas id="network-canvas" class="fixed inset-0 w-full h-full z-0 opacity-40 pointer-events-none"></canvas>

<div class="relative z-10 w-full bg-zinc-950 min-h-screen text-white pt-16 pb-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        
        <!-- INTESTAZIONE MINIMALISTA -->
        <div class="mb-12 border-b border-white/10 pb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-5xl md:text-7xl font-black uppercase italic tracking-tighter text-white">
                    News & Feed
                </h1>
                <p class="text-[#d9ff00] uppercase tracking-widest text-xs mt-3 font-bold font-mono italic">
                    [04] Comunicazioni ufficiali & articoli della community
                </p>
            </div>
            <div class="text-xs font-mono text-zinc-500 uppercase tracking-widest">
                TOTALE ARTICOLI: <span class="text-[#d9ff00] font-bold">{{ method_exists($news, 'total') ? $news->total() : $news->count() }}</span>
            </div>
        </div>

        <!-- CORPO NEWS / GRIGLIA GEOMETRICA -->
        <div class="space-y-6">
            @forelse($news as $article)
                <article class="group bg-zinc-900/40 hover:bg-zinc-900/80 border border-white/5 hover:border-[#d9ff00]/50 rounded-md p-6 md:p-8 transition-all duration-300 backdrop-blur-md grid md:grid-cols-3 gap-8 items-center">
                    
                    {{-- Image Wrapper --}}
                    <div class="relative w-full overflow-hidden rounded-sm border border-white/10 aspect-video md:aspect-4/3">
                        @if($article->image_path)
                            <img src="{{ asset('storage/' . $article->image_path) }}" 
                                 alt="{{ $article->title }}" 
                                 loading="lazy"
                                 class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700">
                        @else
                            <div class="w-full h-full bg-zinc-900 flex items-center justify-center">
                                <span class="text-zinc-700 font-black text-2xl italic tracking-tighter">RUDE-HZ</span>
                            </div>
                        @endif
                    </div>

                    {{-- Text Content --}}
                    <div class="md:col-span-2 flex flex-col justify-between h-full space-y-4">
                        <div>
                            <span class="text-[10px] font-mono text-zinc-500 uppercase tracking-widest">
                                {{ $article->created_at->format('d . m . Y') }}
                            </span>
                            
                            <h2 class="text-2xl md:text-3xl font-black text-white uppercase tracking-tighter leading-tight mt-2 mb-3 group-hover:text-[#d9ff00] transition-colors">
                                {{ $article->title }}
                            </h2>
                            
                            <p class="text-zinc-400 text-xs md:text-sm font-mono leading-relaxed line-clamp-3">
                                {{ $article->excerpt ?? Str::limit(strip_tags($article->content), 150) }}
                            </p>
                        </div>

                        <div class="pt-4">
                            <a href="{{ route('news.show', $article->slug) }}" 
                               class="inline-flex items-center gap-2 px-4 py-2 bg-zinc-900 border border-white/20 text-white font-mono uppercase italic tracking-wider text-xs rounded-sm group-hover:bg-[#d9ff00] group-hover:text-black group-hover:border-[#d9ff00] transition-all">
                                <span>Leggi articolo</span>
                                <span class="transition-transform group-hover:translate-x-1">→</span>
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="bg-zinc-900/40 border border-white/5 rounded-md p-12 text-center backdrop-blur-md">
                    <p class="text-zinc-600 italic uppercase font-mono text-xs">// Archivio News Non Rilevato //</p>
                </div>
            @endforelse
        </div>

        <!-- PAGINAZIONE STILIZZATA -->
        @if(method_exists($news, 'links') && $news->hasPages())
        <div class="mt-16 flex justify-center">
            <div class="bg-zinc-900/60 border border-white/10 rounded-md p-3 backdrop-blur-md font-mono text-xs">
                {{ $news->links() }}
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

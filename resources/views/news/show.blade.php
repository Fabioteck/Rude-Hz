@extends('layouts.frontend')

@section('content')
<!-- SFONDO NEURONALE ESTESO A TUTTA LA PAGINA (OPACITÀ RIDOTTA A 20% PER LEGGIBILITÀ) -->
<canvas id="network-canvas" class="fixed inset-0 w-full h-full z-0 opacity-20 pointer-events-none"></canvas>

<div class="relative z-10 w-full bg-zinc-950 min-h-screen text-white pt-16 pb-24">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        
        <!-- LINK DI RITORNO UNDERGROUND -->
        <div class="mb-12">
            <a href="{{ route('news.index') }}" class="text-xs font-bold text-zinc-500 uppercase tracking-widest font-mono italic hover:text-[#d9ff00] transition-colors flex items-center gap-2 group">
                <span class="transition-transform group-hover:-translate-x-1">←</span> Back to news archive
            </a>
        </div>

        <article class="space-y-8">
            
            <!-- HEADER EDITORIALE MINIMALE -->
            <header class="space-y-4">
                <div class="flex items-center gap-3 font-mono text-xs text-zinc-500 uppercase tracking-widest">
                    <span>// PUBLISHED: {{ $news->created_at->format('d . m . Y') }}</span>
                    @if(isset($news->category) && $news->category)
                        <span>•</span>
                        <span class="text-[#d9ff00]">{{ $news->category->name }}</span>
                    @endif
                </div>

                <h1 class="text-4xl sm:text-6xl font-black uppercase italic tracking-tighter text-white leading-none">
                    {{ $news->title }}
                </h1>
            </header>

            <!-- COPERTINA ARTICOLO -->
            @if($news->image_path)
                <div class="relative w-full overflow-hidden rounded-md border border-white/10 aspect-video shadow-2xl">
                    <img src="{{ asset('storage/' . $news->image_path) }}" 
                         alt="{{ $news->title }}" 
                         class="w-full h-full object-cover">
                </div>
            @endif

            <!-- CORPO DELL'ARTICOLO DENTRO BENTO CONTAINER -->
            <div class="bg-zinc-900/40 border border-white/5 rounded-md p-8 md:p-12 backdrop-blur-md space-y-6">
                <div class="prose prose-invert prose-p:text-zinc-300 prose-p:text-base prose-p:font-mono prose-p:leading-relaxed prose-a:text-[#d9ff00] hover:prose-a:text-white max-w-none">
                    {!! nl2br(e($news->content)) !!}
                </div>
            </div>

            <!-- CORRELATI O FOOTER ARTICOLO -->
            @if(isset($relatedNews) && $relatedNews->isNotEmpty())
            <div class="pt-12 border-t border-white/10 space-y-6">
                <h3 class="text-xs font-mono text-zinc-500 uppercase tracking-widest">Related Articles</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    @foreach($relatedNews as $rel)
                    <a href="{{ route('news.show', $rel->slug) }}" class="p-4 bg-zinc-900/40 hover:bg-zinc-900/80 border border-white/5 rounded-md transition group block backdrop-blur-md">
                        <div class="text-[9px] font-mono text-zinc-500 uppercase tracking-widest mb-1">
                            {{ $rel->created_at->format('d . m . Y') }}
                        </div>
                        <h4 class="font-bold text-sm uppercase tracking-tight text-white group-hover:text-[#d9ff00] transition line-clamp-2">
                            {{ $rel->title }}
                        </h4>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

        </article>

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
        const count = isMobile ? 20 : Math.min(Math.floor((width * height) / 22000), 50);
        
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
            this.vx = (Math.random() - 0.5) * 0.8;
            this.vy = (Math.random() - 0.5) * 0.8;
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
                    ctx.strokeStyle = `rgba(217, 255, 0, ${0.2 * (1 - dist / connectionDist)})`;
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

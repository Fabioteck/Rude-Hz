@extends('layouts.frontend')

@section('title', 'Tracce in Rotazione & Archivio Digitale - Rude-Hz')
@section('meta_description', 'Ascolta le ultime tracce di musica elettronica, tekno e hard sound caricate dai producer della community Rude-Hz.')

@section('content')
<!-- SFONDO NEURONALE ESTESO A TUTTA LA PAGINA -->
<canvas id="network-canvas" class="fixed inset-0 w-full h-full z-0 opacity-40 pointer-events-none"></canvas>

<div class="relative z-10 w-full bg-zinc-950 min-h-screen text-white pt-16 pb-36">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        
        <!-- INTESTAZIONE MINIMALISTA -->
        <div class="mb-12 border-b border-white/10 pb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-5xl md:text-7xl font-black uppercase italic tracking-tighter text-white">
                    Tracks
                </h1>
                <p class="text-[#d9ff00] uppercase tracking-widest text-xs mt-3 font-bold font-mono italic">
                    [01] Ultime tracce in rotazione & archivio digitale
                </p>
            </div>
            <div class="text-xs font-mono text-zinc-500 uppercase tracking-widest">
                TOTALE TRACCE: <span class="text-[#d9ff00] font-bold">{{ method_exists($tracks, 'total') ? $tracks->total() : $tracks->count() }}</span>
            </div>
        </div>

        <!-- TABELLA AUDIO TECNICA (DAW / SEQUENCER STYLE) -->
        <div class="w-full overflow-x-auto border border-white/10 rounded-md bg-zinc-900/20 backdrop-blur-md">
            <table class="w-full text-left border-collapse font-mono text-xs">
                <thead>
                    <tr class="border-b border-white/10 text-zinc-500 uppercase tracking-widest bg-zinc-900/60">
                        <th class="py-3 px-4 w-12 text-center">#</th>
                        <th class="py-3 px-4">Titolo / Traccia</th>
                        <th class="py-3 px-4">Produttore</th>
                        <th class="py-3 px-4">Genere</th>
                        <th class="py-3 px-4 text-center">Caricata il</th>
                        <th class="py-3 px-4 text-right">Ascolta</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($tracks as $index => $track)
                    <tr id="track-row-{{ $index }}" class="bg-zinc-900/20 hover:bg-zinc-900/85 transition-all duration-200 group backdrop-blur-md">
                        <!-- # (Numero sequenziale tenendo conto della paginazione) -->
                        <td class="py-4 px-4 text-center text-zinc-600 font-bold">
                            {{ method_exists($tracks, 'firstItem') && $tracks->firstItem() ? str_pad($tracks->firstItem() + $index, 2, '0', STR_PAD_LEFT) : str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                        </td>

                        <!-- Titolo / Cover -->
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-3 truncate">
                                <div class="w-9 h-9 rounded-sm bg-zinc-800 border border-white/10 flex items-center justify-center overflow-hidden shrink-0 group-hover:border-[#d9ff00] transition-colors">
                                    @if(!empty($track->cover_path))
                                        <img src="{{ asset('storage/'.$track->cover_path) }}" alt="{{ $track->title }} - {{ $track->artist->name ?? 'Unknown' }}" loading="lazy" class="w-full h-full object-cover" onerror="this.src='{{ \App\Services\ImageOptimizerService::placeholderUrl() }}'">
                                    @else
                                        <img src="{{ \App\Services\ImageOptimizerService::placeholderUrl() }}" alt="Placeholder" loading="lazy" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <a href="{{ route('track.public.show', $track->slug) }}" class="font-bold text-sm uppercase tracking-tight text-white group-hover:text-[#d9ff00] transition-colors line-clamp-1">
                                    {{ $track->title }}
                                </a>
                            </div>
                        </td>

                        <!-- Produttore (Artista) -->
                        <td class="py-4 px-4 uppercase text-zinc-300 group-hover:text-[#d9ff00] font-semibold tracking-wider transition-colors">
                            {{ $track->artist->name ?? 'Unknown' }}
                        </td>

                        <!-- Genere -->
                        <td class="py-4 px-4 uppercase">
                            <span class="ds-badge px-2.5 py-1 text-[10px]">
                                {{ $track->genre ?? 'TEKNO' }}
                            </span>
                        </td>

                        <!-- Data di caricamento -->
                        <td class="py-4 px-4 text-center text-zinc-500 text-[11px]">
                            {{ $track->created_at->format('d . m . Y') }}
                        </td>

                        <!-- Azione Ascolta (Micro-icona geometrica) -->
                        <td class="py-4 px-4 text-right">
                            <button type="button" 
                                    onclick="playRudeTrack({{ $track->id }})"
                                    class="inline-flex items-center justify-center w-8 h-8 bg-zinc-900 border border-white/20 text-[#d9ff00] group-hover:bg-[#d9ff00] group-hover:text-black group-hover:border-[#d9ff00] transition-all rounded-sm shadow-sm"
                                    title="Ascolta traccia">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-16 text-center text-zinc-600 italic uppercase font-mono">
                            Nessuna traccia disponibile al momento.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINAZIONE STILIZZATA -->
        @if(method_exists($tracks, 'links') && $tracks->hasPages())
        <div class="mt-16 flex justify-center">
            <div class="bg-zinc-900/60 border border-white/10 rounded-md p-3 backdrop-blur-md font-mono text-xs">
                {{ $tracks->links() }}
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

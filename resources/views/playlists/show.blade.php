@extends('layouts.frontend')

@section('content')
<!-- SFONDO NEURONALE ESTESO A TUTTA LA PAGINA -->
<canvas id="network-canvas" class="fixed inset-0 w-full h-full z-0 opacity-30 pointer-events-none"></canvas>

<!-- CONTENITORE PRINCIPALE CON PADDING BOTTOM PER EVITARE SOVRAPPOSIZIONI DEL PLAYER STICKY -->
<div class="relative z-10 w-full bg-zinc-950 min-h-screen text-white pt-16 pb-36">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        
        <!-- LINK DI RITORNO UNDERGROUND -->
        <div class="mb-12">
            <a href="{{ route('playlists.index') }}" class="text-xs font-bold text-zinc-500 uppercase tracking-widest font-mono italic hover:text-[#d9ff00] transition-colors flex items-center gap-2 group">
                <span class="transition-transform group-hover:-translate-x-1">←</span> Back to playlists
            </a>
        </div>

        <!-- DETTAGLI PLAYLIST SELEZIONATA (BENTO HEADER) -->
        <div class="mb-16 bg-zinc-900/40 border border-white/5 rounded-md p-8 backdrop-blur-md flex flex-col md:flex-row md:items-end md:justify-between gap-8">
            <div class="max-w-3xl">
                <div class="flex items-center gap-4 mb-4">
                    <span class="px-2.5 py-0.5 bg-[#d9ff00]/10 border border-[#d9ff00]/30 text-[#d9ff00] text-[9px] font-mono uppercase font-bold rounded-sm">
                        Official Selection
                    </span>
                    <span class="text-zinc-500 text-xs font-mono uppercase italic">
                        Added {{ $playlist->created_at->diffForHumans() }}
                    </span>
                </div>
                <h1 class="text-5xl md:text-7xl font-black uppercase italic tracking-tighter text-white">
                    {{ $playlist->title ?? $playlist->name }}
                </h1>
                <p class="text-zinc-400 text-sm font-mono italic mt-4 leading-relaxed max-w-2xl">
                    {{ $playlist->description ?? 'No description provided for this selection.' }}
                </p>
            </div>

            <!-- Contatore Tracce Stile Pillola Tecnica -->
            <div class="bg-zinc-900/80 border border-white/10 rounded-md px-6 py-4 text-center self-start md:self-end min-w-[140px] backdrop-blur-md">
                <span class="text-[10px] font-bold text-zinc-500 uppercase tracking-widest font-mono block">Total Tracks</span>
                <span class="text-3xl font-black text-[#d9ff00] mt-1 block font-mono">{{ $playlist->tracks->count() }}</span>
            </div>
        </div>

        <!-- SEZIONE LISTA TRACCE (DAW STYLE TABLE) -->
        <div class="space-y-4">
            <div class="flex items-center justify-between pb-4 border-b border-white/10">
                <div>
                    <h3 class="text-2xl font-black uppercase italic tracking-tighter">Tracklist</h3>
                    <p class="text-[10px] font-mono text-[#d9ff00] uppercase tracking-widest mt-1">Tracce incluse nella selezione</p>
                </div>
                <div class="text-xs font-mono text-zinc-500 uppercase">
                    TOTALE: <span class="text-[#d9ff00] font-bold">{{ $playlist->tracks->count() }}</span>
                </div>
            </div>

            @if($playlist->tracks->isEmpty())
                <div class="ds-card p-16 text-center backdrop-blur-md max-w-lg mx-auto">
                    <div class="w-16 h-16 mx-auto mb-6 rounded-md bg-[#d9ff00]/10 border border-[#d9ff00]/30 flex items-center justify-center text-[#d9ff00] text-xl font-mono font-black">
                        00
                    </div>
                    <h4 class="text-xl font-black uppercase tracking-tighter text-white mb-2">Playlist Vuota</h4>
                    <p class="text-xs text-zinc-400 font-mono italic uppercase mb-6">Questa playlist non contiene ancora alcuna traccia musicale.</p>
                    <a href="{{ route('tracks.index') }}" class="inline-block px-6 py-3 ds-btn text-xs tracking-widest shadow-lg">
                        Esplora Tracce
                    </a>
                </div>
            @else
                <!-- TABELLA AUDIO TECNICA (DAW STYLE) -->
                <div class="w-full overflow-x-auto border border-white/10 rounded-md bg-zinc-900/20 backdrop-blur-md">
                    <table class="w-full text-left border-collapse font-mono text-xs">
                        <thead>
                            <tr class="border-b border-white/10 text-zinc-500 uppercase tracking-widest bg-zinc-900/60">
                                <th class="py-3 px-4 w-12 text-center">#</th>
                                <th class="py-3 px-4">Titolo / Traccia</th>
                                <th class="py-3 px-4">Artista</th>
                                <th class="py-3 px-4">Genere</th>
                                <th class="py-3 px-4 text-center">Durata</th>
                                <th class="py-3 px-4 text-right">Ascolta</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @foreach($playlist->tracks as $index => $track)
                            <tr id="track-row-{{ $index }}" class="bg-zinc-900/25 hover:bg-zinc-900/80 transition-all duration-200 group backdrop-blur-md">
                                <td class="py-4 px-4 text-center text-zinc-600 font-bold">
                                    {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-3 truncate">
                                        <div class="w-9 h-9 rounded-sm bg-zinc-800 border border-white/10 flex items-center justify-center overflow-hidden shrink-0 group-hover:border-[#d9ff00] transition-colors">
                                            @if(!empty($track->cover_path))
                                                <img src="{{ asset('storage/'.$track->cover_path) }}" class="w-full h-full object-cover" onerror="this.src='{{ \App\Services\ImageOptimizerService::placeholderUrl() }}'">
                                            @else
                                                <img src="{{ \App\Services\ImageOptimizerService::placeholderUrl() }}" class="w-full h-full object-cover" alt="Placeholder">
                                            @endif
                                        </div>
                                        <a href="{{ route('track.public.show', $track->slug ?? '') }}" class="font-bold text-sm uppercase tracking-tight text-white group-hover:text-[#d9ff00] transition-colors line-clamp-1">
                                            {{ $track->title ?? $track->name }}
                                        </a>
                                    </div>
                                </td>
                                <td class="py-4 px-4 uppercase text-zinc-300 group-hover:text-[#d9ff00] font-semibold tracking-wider transition-colors">
                                    {{ $track->artist->name ?? 'Unknown Artist' }}
                                </td>
                                <td class="py-4 px-4 uppercase">
                                    <span class="ds-badge px-2.5 py-1 text-[10px]">
                                        {{ $track->genre ?? 'TEKNO' }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-center text-zinc-500 text-[11px]">
                                    {{ $track->duration_label ?? '03:45' }}
                                </td>
                                <td class="py-4 px-4 text-right">
                                    <button type="button" 
                                            onclick="Livewire.dispatch('playTrack', { trackId: {{ $track->id }} })"
                                            class="inline-flex items-center justify-center w-8 h-8 bg-zinc-900 border border-white/20 text-[#d9ff00] group-hover:bg-[#d9ff00] group-hover:text-black group-hover:border-[#d9ff00] transition-all rounded-sm shadow-sm"
                                            title="Ascolta traccia">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>
</div>

<!-- CANVAS NEURONALE OTTIMIZZATO PER RASPBERRY PI 4 -->
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

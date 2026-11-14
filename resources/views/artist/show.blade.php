@extends('layouts.frontend')

@section('content')
<!-- SFONDO NEURONALE ESTESO A TUTTA LA PAGINA -->
<canvas id="network-canvas" class="fixed inset-0 w-full h-full z-0 opacity-30 pointer-events-none"></canvas>

<div class="relative z-10 w-full bg-zinc-950 min-h-screen text-white pt-16 pb-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        
        <!-- LINK DI RITORNO UNDERGROUND -->
        <div class="mb-12">
            <a href="{{ route('artists.index') }}" class="text-xs font-bold text-zinc-500 uppercase tracking-widest font-mono italic hover:text-[#d9ff00] transition-colors flex items-center gap-2 group">
                <span class="transition-transform group-hover:-translate-x-1">←</span> Back to artists
            </a>
        </div>

        <!-- BENTO LAYOUT DUE COLONNE -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-16">
            
            <!-- COLONNA SINISTRA: AVATAR & SOCIAL/CRYPTO (1 Colonna su LG) -->
            <div class="space-y-6">
                <div class="bg-zinc-900/40 border border-white/5 rounded-md p-6 backdrop-blur-md space-y-6 text-center">
                    
                    <!-- AVATAR COMPATTO CON BORDO GIALLO ACIDO -->
                    <div class="w-36 h-36 mx-auto bg-zinc-900 rounded-sm overflow-hidden border-2 border-[#d9ff00]/50 shadow-xl relative">
                        @if($artist->profile_image)
                            <img src="{{ Storage::url($artist->profile_image) }}" 
                                 loading="lazy" 
                                 class="w-full h-full object-cover" 
                                 alt="{{ $artist->name }}">
                        @else
                            <img src="{{ \App\Services\ImageOptimizerService::placeholderUrl() }}" class="w-full h-full object-cover absolute inset-0" alt="Placeholder">
                        @endif
                    </div>

                    <div>
                        <span class="px-2.5 py-0.5 bg-[#d9ff00]/10 border border-[#d9ff00]/30 text-[#d9ff00] text-[9px] font-mono uppercase font-bold rounded-sm">
                            Rude Artist
                        </span>
                        <h1 class="text-3xl font-black uppercase italic tracking-tighter text-white mt-3">
                            {{ $artist->name }}
                        </h1>
                        <p class="text-xs text-[#d9ff00] uppercase tracking-widest font-mono font-bold mt-1">
                            {{ $artist->style ?? 'Techno / Tekno' }}
                        </p>
                    </div>

                    <!-- SOCIAL & CRYPTO LINKS IN FONT MONO -->
                    <div class="pt-4 border-t border-white/5 space-y-2 text-left font-mono text-xs">
                        <div class="text-[10px] text-zinc-500 uppercase tracking-widest mb-3">Links & Connections</div>
                        
                        @if($artist->spotify_url)
                            <a href="{{ $artist->spotify_url }}" target="_blank" class="flex items-center justify-between p-2.5 bg-zinc-900/60 hover:bg-zinc-900 rounded-sm border border-white/5 text-zinc-300 hover:text-[#d9ff00] transition">
                                <span>Spotify</span>
                                <span>↗</span>
                            </a>
                        @endif
                        @if($artist->soundcloud_url)
                            <a href="{{ $artist->soundcloud_url }}" target="_blank" class="flex items-center justify-between p-2.5 bg-zinc-900/60 hover:bg-zinc-900 rounded-sm border border-white/5 text-zinc-300 hover:text-[#d9ff00] transition">
                                <span>SoundCloud</span>
                                <span>↗</span>
                            </a>
                        @endif
                        @if($artist->instagram_url)
                            <a href="{{ $artist->instagram_url }}" target="_blank" class="flex items-center justify-between p-2.5 bg-zinc-900/60 hover:bg-zinc-900 rounded-sm border border-white/5 text-zinc-300 hover:text-[#d9ff00] transition">
                                <span>Instagram</span>
                                <span>↗</span>
                            </a>
                        @endif
                        @if($artist->youtube_url)
                            <a href="{{ $artist->youtube_url }}" target="_blank" class="flex items-center justify-between p-2.5 bg-zinc-900/60 hover:bg-zinc-900 rounded-sm border border-white/5 text-zinc-300 hover:text-[#d9ff00] transition">
                                <span>YouTube</span>
                                <span>↗</span>
                            </a>
                        @endif
                        @if($artist->nostr_npub)
                            <div class="p-2.5 bg-zinc-900/60 rounded-sm border border-white/5 text-zinc-400 text-[10px] truncate" title="{{ $artist->nostr_npub }}">
                                <span class="text-[#d9ff00]">Nostr:</span> {{ Str::limit($artist->nostr_npub, 18) }}
                            </div>
                        @endif
                        @if($artist->ln_address)
                            <div class="p-2.5 bg-zinc-900/60 rounded-sm border border-white/5 text-zinc-400 text-[10px] truncate" title="{{ $artist->ln_address }}">
                                <span class="text-[#d9ff00]">Lightning:</span> {{ $artist->ln_address }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- COLONNA DESTRA: BIOGRAFIA & LISTA TRACCE (2 Colonne su LG) -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- BIOGRAFIA -->
                <div class="bg-zinc-900/40 border border-white/5 rounded-md p-8 backdrop-blur-md">
                    <span class="text-[9px] font-mono text-[#d9ff00] uppercase tracking-widest font-bold border border-[#d9ff00]/30 px-2.5 py-0.5 rounded-sm bg-[#d9ff00]/5">
                        Bio
                    </span>
                    <h2 class="text-2xl font-black uppercase italic tracking-tighter text-white mt-4 mb-4">
                        Biografia & Percorso
                    </h2>
                    <div class="text-zinc-300 text-sm font-mono leading-relaxed space-y-4">
                        @if($artist->bio)
                            {!! nl2br(e($artist->bio)) !!}
                        @else
                            <p class="text-zinc-500 italic">Nessuna biografia inserita per questo artista.</p>
                        @endif
                    </div>
                </div>

                <!-- SEZIONE TRACCE DELL'ARTISTA (DAW STYLE TABLE) -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between pb-4 border-b border-white/10">
                        <div>
                            <h3 class="text-2xl font-black uppercase italic tracking-tighter">Released Tracks</h3>
                            <p class="text-[10px] font-mono text-[#d9ff00] uppercase tracking-widest mt-1">Tracce approvate in rotazione</p>
                        </div>
                        <div class="text-xs font-mono text-zinc-500 uppercase">
                            TOTALE: <span class="text-[#d9ff00] font-bold">{{ $tracks->count() }}</span>
                        </div>
                    </div>

                    @if($tracks->isEmpty())
                        <div class="ds-card p-12 text-center backdrop-blur-md">
                            <div class="w-12 h-12 mx-auto mb-4 rounded-md bg-[#d9ff00]/10 border border-[#d9ff00]/30 flex items-center justify-center text-[#d9ff00] text-lg font-mono font-black">
                                00
                            </div>
                            <p class="text-xs text-zinc-400 font-mono italic uppercase tracking-wider">Nessuna traccia pubblicata — profilo in costruzione.</p>
                        </div>
                    @else
                        <!-- TABELLA AUDIO TECNICA (DAW STYLE) -->
                        <div class="w-full overflow-x-auto border border-white/10 rounded-md bg-zinc-900/20 backdrop-blur-md">
                            <table class="w-full text-left border-collapse font-mono text-xs">
                                <thead>
                                    <tr class="border-b border-white/10 text-zinc-500 uppercase tracking-widest bg-zinc-900/60">
                                        <th class="py-3 px-4 w-12 text-center">#</th>
                                        <th class="py-3 px-4">Titolo / Traccia</th>
                                        <th class="py-3 px-4">Genere</th>
                                        <th class="py-3 px-4 text-center">BPM / Key</th>
                                        <th class="py-3 px-4 text-right">Ascolta</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-white/5">
                                    @foreach($tracks as $index => $track)
                                    <tr class="bg-zinc-900/20 hover:bg-zinc-900/80 transition-all duration-200 group backdrop-blur-md">
                                        <td class="py-4 px-4 text-center text-zinc-600 font-bold">
                                            {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                        </td>
                                        <td class="py-4 px-4">
                                            <div class="flex items-center gap-3 truncate">
                                                <div class="w-8 h-8 rounded-sm bg-zinc-800 border border-white/10 flex items-center justify-center text-zinc-400 group-hover:border-[#d9ff00] transition-colors shrink-0">
                                                    🎵
                                                </div>
                                                <a href="{{ route('track.public.show', $track->slug) }}" class="font-bold text-sm uppercase tracking-tight text-white group-hover:text-[#d9ff00] transition-colors line-clamp-1">
                                                    {{ $track->title ?? $track->name }}
                                                </a>
                                            </div>
                                        </td>
                                        <td class="py-4 px-4 uppercase text-zinc-400">
                                            <span class="px-2.5 py-1 bg-white/5 border border-white/10 rounded-sm text-[10px] text-zinc-300 group-hover:text-[#d9ff00] group-hover:border-[#d9ff00]/30 transition-colors">
                                                {{ $track->genre ?? 'TEKNO' }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-4 text-center text-zinc-500 text-[11px]">
                                            {{ $track->bpm ?? '140' }} BPM {{ $track->key ? '• '.$track->key : '' }}
                                        </td>
                                        <td class="py-4 px-4 text-right">
                                            <button type="button" 
                                                    onclick="playRudeTrack({{ $track->id }})"
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

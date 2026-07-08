@extends('layouts.frontend')

@section('content')

    <!-- HERO SECTION -->
    <section class="relative h-[70vh] min-h-[500px] flex items-center justify-center text-center px-4 overflow-hidden bg-black">
        <canvas id="network-canvas" class="absolute inset-0 w-full h-full z-0"></canvas>
        <div class="relative z-10">
            <h1 class="text-6xl md:text-8xl font-black uppercase tracking-tighter mb-4 leading-none text-white">
                The Harder <br> <span class="text-[#d9ff00]">Side of Sound</span>
            </h1>
            <p class="text-gray-400 text-lg mb-8">La community tekno nata dai social.</p>
        </div>
    </section>

    @php 
        $latestTrack = $tracks->first(); 
    @endphp

    <!-- SEZIONE NEWS -->
    <section id="news" class="py-24 bg-white border-t border-black/[0.03]">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-12">
                <h2 class="text-4xl font-black uppercase italic tracking-tighter text-gray-900">Latest News</h2>
                <p class="text-[#d9ff00] uppercase tracking-widest text-xs mt-2 font-bold font-mono italic">Le ultime notizie</p>
            </div>
            @if($latestNews)
            <a href="{{ route('news.show', $latestNews->slug) }}" class="group block grid md:grid-cols-2 gap-8 items-center bg-gray-50 p-6 rounded-3xl hover:bg-gray-100 transition">
                <div class="rounded-2xl overflow-hidden shadow-lg">
                    <img src="{{ asset('storage/' . $latestNews->image_path) }}" 
                        class="w-full aspect-video object-cover grayscale group-hover:grayscale-0 transition-all duration-700">
                </div>
                <div>
                    <span class="text-[10px] font-black text-gray-500 uppercase tracking-widest">{{ $latestNews->created_at->format('d . m . Y') }}</span>
                    <h3 class="text-3xl font-black text-gray-900 tracking-tighter leading-[0.9] mt-2 mb-4 group-hover:text-gray-900 transition-colors">
                        {{ strtoupper($latestNews->title) }}
                    </h3>
                    <p class="text-gray-600 text-sm line-clamp-3">{{ $latestNews->excerpt }}</p>
                    <div class="mt-6 inline-flex items-center text-[10px] font-black uppercase tracking-widest text-[#d9ff00] group-hover:gap-4 transition-all">
                        Read More <span class="ml-2">→</span>
                    </div>
                </div>
            </a>
            @endif
        </div>
    </section>

    
    <!-- PLAYER AUDIO NASCOSTO -->
    <audio id="main-audio-player" src="{{ $latestTrack ? Storage::url($latestTrack->file_path) : '' }}" preload="auto"></audio>

    
   <!-- SEZIONE TRACCE -->
   <section id="tracks" class="py-20 border-t border-white/5">
       <div class="max-w-5xl mx-auto px-4">
           <h2 class="text-2xl font-black uppercase mb-10 italic tracking-tight">Latest Drops</h2>

           <div class="space-y-2">
               @forelse($tracks->take(5) as $track)
               {{-- Aggiunto il link alla pagina show --}}
               <a href="{{ route('track.public.show', $track->slug) }}" class="flex items-center justify-between p-4 bg-[#111111] hover:bg-[#171717] rounded-xl border border-white/5 transition group">
                   <div class="flex items-center gap-4">
                       {{-- Il pulsante play mantiene la sua funzione JS --}}
                       <button onclick="event.preventDefault(); playTrack('{{ Storage::url($track->file_path) }}', '{{ $track->title }}', '{{ $track->artist->name }}')" 
                               class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center group-hover:bg-[#d9ff00] group-hover:text-black transition">
                           <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"></path></svg>
                       </button>
                       <div>
                           <h4 class="font-bold uppercase tracking-tight text-sm text-white">{{ $track->title }}</h4>
                           <p class="text-[10px] text-gray-500 uppercase italic font-medium">{{ $track->artist->name ?? 'Unknown' }}</p>
                       </div>
                   </div>
                   <div class="text-right flex items-center gap-4">
                       <span class="text-xs font-mono text-zinc-600 uppercase">{{ $track->genre }}</span>
                       {{-- Icona freccia per indicare il link --}}
                       <svg class="w-4 h-4 text-zinc-800 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                   </div>
               </a>
               @empty
               <p class="text-zinc-700 italic text-center py-10">No tracks available yet.</p>
               @endforelse
           </div>
       </div>
   </section>

   @endsection

   @push('scripts')
   <script>
   function playTrack(url, title, artist) {
       const audio = document.getElementById('main-audio-player');
       audio.src = url;
       audio.play();
   }

   // ROBUST NEURAL NETWORK ANIMATION
   const canvas = document.getElementById('network-canvas');
   const ctx = canvas.getContext('2d');

   function setCanvasSize() {
       const parent = canvas.parentElement;
       canvas.width = parent.offsetWidth;
       canvas.height = parent.offsetHeight;
   }

   window.addEventListener('resize', setCanvasSize);
   setCanvasSize();

   let particles = [];
   const particleCount = 60;
   const connectionDist = 120;

   class Particle {
       constructor() {
           this.init();
       }
       init() {
           this.x = Math.random() * canvas.width;
           this.y = Math.random() * canvas.height;
           this.vx = (Math.random() - 0.5) * 2;
           this.vy = (Math.random() - 0.5) * 2;
       }
       update() {
           this.x += this.vx;
           this.y += this.vy;
           if (this.x < 0 || this.x > canvas.width) this.vx *= -1;
           if (this.y < 0 || this.y > canvas.height) this.vy *= -1;
       }
       draw() {
           ctx.beginPath();
           ctx.arc(this.x, this.y, 1.5, 0, Math.PI * 2);
           ctx.fillStyle = 'rgba(255, 255, 255, 0.5)';
           ctx.fill();
       }
   }

   for (let i = 0; i < particleCount; i++) particles.push(new Particle());

   function animate() {
       ctx.clearRect(0, 0, canvas.width, canvas.height);

       particles.forEach(p => {
           p.update();
           p.draw();
       });

       for (let i = 0; i < particles.length; i++) {
           for (let j = i + 1; j < particles.length; j++) {
               const dx = particles[i].x - particles[j].x;
               const dy = particles[i].y - particles[j].y;
               const dist = Math.sqrt(dx * dx + dy * dy);
               if (dist < connectionDist) {
                   ctx.beginPath();
                   ctx.strokeStyle = `rgba(255, 255, 255, ${0.2 * (1 - dist / connectionDist)})`;
                   ctx.lineWidth = 1;
                   ctx.moveTo(particles[i].x, particles[i].y);
                   ctx.lineTo(particles[j].x, particles[j].y);
                   ctx.stroke();
               }
           }
       }
       requestAnimationFrame(animate);
   }
   animate();
   </script>
   @endpush


   <!-- SISTEMA DI TRACCIAMENTO TEMPO DI PERMANENZA E METADATI (ANALYTICS) -->
@if(session('last_analytics_id'))
<meta name="analytics-id" content="{{ session('last_analytics_id') }}">
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const analyticsId = document.querySelector('meta[name="analytics-id"]')?.getAttribute('content');
        if (!analyticsId) return;

        const pingInterval = 15; // Invia un aggiornamento ogni 15 secondi
        const apiUrl = "/api/analytics/metadata"; // URL statico assoluto, zero errori di rotta

        setInterval(() => {
            const data = new FormData();
            data.append('analytics_id', analyticsId);
            data.append('seconds', pingInterval);
            data.append('screen_resolution', window.screen.width + 'x' + window.screen.height);
            data.append('connection_type', navigator.connection ? navigator.connection.effectiveType : 'unknown');

            // navigator.sendBeacon garantisce l'esecuzione dello script in background anche se l'utente chiude la scheda
            if (navigator.sendBeacon) {
                navigator.sendBeacon(apiUrl, data);
            } else {
                fetch(apiUrl, { method: 'POST', body: data, keepalive: true });
            }
        }, pingInterval * 1000);
    });
</script>
@endif

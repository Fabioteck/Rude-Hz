@extends('layouts.frontend')

@section('title', 'Project & Manifesto - Rude-Hz')
@section('meta_description', 'Scopri la storia, la filosofia e le system specs di Rude-Hz, la community underground nata per unire producer e amanti della musica elettronica.')

@section('content')
<!-- SFONDO NEURONALE ESTESO A TUTTA LA PAGINA -->
<canvas id="network-canvas" class="fixed inset-0 w-full h-full z-0 opacity-25 pointer-events-none"></canvas>

<div class="relative z-10 w-full bg-zinc-950 min-h-screen text-white pt-16 pb-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        
        <!-- INTESTAZIONE MINIMALISTA -->
        <div class="mb-12 border-b border-white/10 pb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-5xl md:text-7xl font-black uppercase italic tracking-tighter text-white">
                    {{ $page->title ?? 'Project' }}
                </h1>
                <p class="text-[#d9ff00] uppercase tracking-widest text-xs mt-3 font-bold font-mono italic">
                    {{ $page->subtitle ?? '[06] Il manifesto underground & la filosofia della community' }}
                </p>
            </div>
            <div class="text-xs font-mono text-zinc-500 uppercase tracking-widest">
                MANIFESTO: <span class="text-[#d9ff00] font-bold">RUDE-HZ-CONNECTIONS</span>
            </div>
        </div>

        <!-- BENTO MANIFESTO GRID -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <!-- CARD PRINCIPALE 1: LA GENESI (2 Colonne) -->
            <div class="md:col-span-2 bg-zinc-900/40 hover:bg-zinc-900/80 border border-white/5 rounded-md p-8 backdrop-blur-md flex flex-col justify-between space-y-6 transition-all duration-300">
                <div>
                    <span class="text-[9px] font-mono text-[#d9ff00] uppercase tracking-widest font-bold border border-[#d9ff00]/30 px-2.5 py-0.5 rounded-sm bg-[#d9ff00]/5">
                        Origini
                    </span>
                    <h3 class="text-2xl md:text-3xl font-black uppercase italic tracking-tighter text-white mt-4 mb-4">
                        La Nostra Storia
                    </h3>
                    <p class="text-zinc-300 text-sm md:text-base font-mono leading-relaxed">
                        Questa è una community nata anni orsono dall'esigenza di piccoli producer di province diverse e lontane, tutti allineati e affamati di informazioni, soprattutto sul mondo della produzione di musica elettronica. Uniti dalla stessa passione, ma all'epoca con pochissimi dati disponibili e ritrovandoci tutti negli stessi luoghi, aprimmo il nostro primo gruppo di produzione su Telegram, ormai più di dieci anni fa.
                    </p>
                </div>
                <div class="text-[11px] font-mono text-zinc-500 uppercase">
                    // Telegram Roots — Over 10 Years Underground
                </div>
            </div>

            <!-- CARD LATERALE: SYSTEM SPECS (1 Colonna) -->
            <div class="bg-zinc-900/40 hover:bg-zinc-900/80 border border-white/5 rounded-md p-6 backdrop-blur-md flex flex-col justify-between space-y-6 transition-all duration-300">
                <div>
                    <span class="text-[9px] font-mono text-[#d9ff00] uppercase tracking-widest font-bold border border-[#d9ff00]/30 px-2.5 py-0.5 rounded-sm bg-[#d9ff00]/5">
                        Specs
                    </span>
                    <h3 class="text-xl font-black uppercase italic tracking-tighter text-white mt-4 mb-4">
                        System Specs
                    </h3>
                    <ul class="space-y-3 font-mono text-xs text-zinc-400">
                        <li class="flex items-center justify-between border-b border-white/5 pb-2">
                            <span>Stack:</span>
                            <span class="text-[#d9ff00] font-bold">Laravel / Tailwind</span>
                        </li>
                        <li class="flex items-center justify-between border-b border-white/5 pb-2">
                            <span>Filosofia:</span>
                            <span class="text-[#d9ff00] font-bold">Open Source</span>
                        </li>
                        <li class="flex items-center justify-between border-b border-white/5 pb-2">
                            <span>Algoritmi:</span>
                            <span class="text-zinc-200 font-bold">Zero / No-Ads</span>
                        </li>
                        <li class="flex items-center justify-between pb-2">
                            <span>Hosting:</span>
                            <span class="text-[#d9ff00] font-bold">Raspberry Pi 4 / Edge</span>
                        </li>
                    </ul>
                </div>
                <div class="text-[10px] font-mono text-zinc-600 uppercase">
                    Status: Stable & Production Ready
                </div>
            </div>

            <!-- CARD SECONDARIA 2: EVOLUZIONE (1 Colonna) -->
            <div class="bg-zinc-900/40 hover:bg-zinc-900/80 border border-white/5 rounded-md p-6 backdrop-blur-md flex flex-col justify-between space-y-4 transition-all duration-300">
                <div>
                    <span class="text-[9px] font-mono text-[#d9ff00] uppercase tracking-widest font-bold border border-[#d9ff00]/30 px-2.5 py-0.5 rounded-sm bg-[#d9ff00]/5">
                        Network
                    </span>
                    <h3 class="text-xl font-black uppercase italic tracking-tighter text-white mt-4 mb-3">
                        L'Evoluzione
                    </h3>
                    <p class="text-zinc-400 text-xs md:text-sm font-mono leading-relaxed">
                        Ne è passata d'acqua sotto i ponti. Molti sono approdati e hanno percorso un pezzo di strada insieme a noi, fino ad arrivare alle posizioni più alte; altri sono scomparsi, inghiottiti dalla vita di tutti i giorni.
                    </p>
                </div>
            </div>

            <!-- CARD PRINCIPALE 3: LA MISSIONE (2 Colonne) -->
            <div class="md:col-span-2 bg-zinc-900/40 hover:bg-zinc-900/80 border border-white/5 rounded-md p-8 backdrop-blur-md flex flex-col justify-between space-y-6 transition-all duration-300">
                <div>
                    <span class="text-[9px] font-mono text-[#d9ff00] uppercase tracking-widest font-bold border border-[#d9ff00]/30 px-2.5 py-0.5 rounded-sm bg-[#d9ff00]/5">
                        Mission
                    </span>
                    <h3 class="text-2xl md:text-3xl font-black uppercase italic tracking-tighter text-white mt-4 mb-4">
                        Condivisione & Crescita
                    </h3>
                    <p class="text-zinc-300 text-sm md:text-base font-mono leading-relaxed">
                        Questa è la continuazione di un progetto di unione e divulgazione: non si pretende di insegnare nulla a nessuno, ma se saremo partecipi della vostra crescita come musicisti e capaci di metterci tutti in connessione, ne saremo fieri.
                    </p>
                </div>
                <div class="pt-4 border-t border-white/5">
                    <p class="text-[#d9ff00] font-mono font-bold text-xs uppercase tracking-widest">
                        Non cerchiamo riconoscimenti, ma partecipazione.<br>
                        <span class="text-white">Stay tuned, stay safe, stay Fr33.</span>
                    </p>
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

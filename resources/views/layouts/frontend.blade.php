<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Rude-Hz - The Harder Side of Sound | Community Tekno & Underground')</title>
    <meta name="description" content="@yield('meta_description', 'Rude-Hz è la community underground e platform per producer di musica elettronica, tekno e sound system. Ascolta tracce, unisciti ai contest e scopri artisti.')">
    <link rel="canonical" href="@yield('canonical', url()->current())">

    <!-- Open Graph Tags -->
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="@yield('canonical', url()->current())">
    <meta property="og:title" content="@yield('title', 'Rude-Hz - The Harder Side of Sound | Community Tekno & Underground')">
    <meta property="og:description" content="@yield('meta_description', 'Rude-Hz è la community underground e platform per producer di musica elettronica, tekno e sound system. Ascolta tracce, unisciti ai contest e scopri artisti.')">
    <meta property="og:image" content="@yield('og_image', asset('images/logo_ruders.png'))">

    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#d9ff00">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="bg-[#0a0a0a] text-white">

    <!-- NAVIGAZIONE RESPONSIVE STRUTTURATA (Stato inizializzato SOLO qui) -->
    <nav x-data="{ open: false }" class="sticky top-0 z-50 relative bg-[#0a0a0a]/80 backdrop-blur-md border-b border-white/10">
        <div class="max-w-7xl mx-auto px-4 h-20 flex justify-between items-center relative">
            
            <!-- LOGO -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-full border-2 border-[#00FF66] overflow-hidden bg-[#0a0a0a] shadow-[0_0_12px_rgba(0,255,102,0.4)] shrink-0 flex items-center justify-center">
                    <img src="{{ asset('images/rudealien.jpeg') }}" alt="Rude-Hz Alien" class="w-full h-full object-cover">
                </div>
                <span class="text-2xl font-black text-[#d9ff00] uppercase italic tracking-tighter group-hover:text-white transition-colors">Rude-Hz</span>
            </a>
            
            <!-- LINK DESKTOP -->
            <div class="hidden md:flex space-x-8 uppercase text-xs tracking-widest font-bold font-mono italic">
                <a href="{{ route('project') }}" class="hover:text-[#d9ff00] transition {{ request()->routeIs('project') ? 'text-[#d9ff00]' : '' }}">{{ __('messages.menu.project') }}</a>
                <a href="{{ route('artists.index') }}" class="hover:text-[#d9ff00] transition {{ request()->routeIs('artists.*') ? 'text-[#d9ff00]' : '' }}">{{ __('messages.menu.artists') }}</a>
                <a href="{{ route('playlists.index') }}" class="hover:text-[#d9ff00] transition {{ request()->routeIs('playlists.*') ? 'text-[#d9ff00]' : '' }}">{{ __('messages.menu.playlists') }}</a>
                <a href="{{ route('tracks.index') }}" class="hover:text-[#d9ff00] transition {{ request()->routeIs('tracks.*') ? 'text-[#d9ff00]' : '' }}">{{ __('messages.menu.tracks') }}</a>
                <a href="{{ route('news.index') }}" class="hover:text-[#d9ff00] transition {{ request()->routeIs('news.*') ? 'text-[#d9ff00]' : '' }}">{{ __('messages.menu.news') }}</a>
            </div>

            <!-- BOTTONE UTENTE DESKTOP & BANDIERE SVG -->
            <div class="hidden md:flex items-center gap-6">
                <!-- BANDIERE SVG -->
                <div class="flex items-center gap-2">
                    <a href="{{ route('lang.switch', 'it') }}" title="Italiano" class="transition transform hover:scale-110">
                        <svg class="w-6 h-4 rounded-sm overflow-hidden border {{ app()->getLocale() == 'it' ? 'border-[#00FF66] shadow-[0_0_10px_rgba(0,255,102,0.8)]' : 'border-white/20 opacity-60 hover:opacity-100' }}" viewBox="0 0 3 2">
                            <rect width="1" height="2" fill="#008C45"/>
                            <rect x="1" width="1" height="2" fill="#F4F5F0"/>
                            <rect x="2" width="1" height="2" fill="#CD212A"/>
                        </svg>
                    </a>
                    <a href="{{ route('lang.switch', 'en') }}" title="English" class="transition transform hover:scale-110">
                        <svg class="w-6 h-4 rounded-sm overflow-hidden border {{ app()->getLocale() == 'en' ? 'border-[#00FF66] shadow-[0_0_10px_rgba(0,255,102,0.8)]' : 'border-white/20 opacity-60 hover:opacity-100' }}" viewBox="0 0 60 30">
                            <clipPath id="s"><path d="M0,0 v30 h60 v-30 z"/></clipPath>
                            <clipPath id="t"><path d="M30,15 h30 v15 z v-15 h-30 z h-30 v-15 z v15 h30 z"/></clipPath>
                            <g clip-path="url(#s)">
                                <path d="M0,0 v30 h60 v-30 z" fill="#012169"/>
                                <path d="M0,0 L60,30 M60,0 L0,30" stroke="#fff" stroke-width="6"/>
                                <path d="M0,0 L60,30 M60,0 L0,30" clip-path="url(#t)" stroke="#C8102E" stroke-width="4"/>
                                <path d="M30,0 v30 M0,15 h60" stroke="#fff" stroke-width="10"/>
                                <path d="M30,0 v30 M0,15 h60" stroke="#C8102E" stroke-width="6"/>
                            </g>
                        </svg>
                    </a>
                    <a href="{{ route('lang.switch', 'es') }}" title="Español" class="transition transform hover:scale-110">
                        <svg class="w-6 h-4 rounded-sm overflow-hidden border {{ app()->getLocale() == 'es' ? 'border-[#00FF66] shadow-[0_0_10px_rgba(0,255,102,0.8)]' : 'border-white/20 opacity-60 hover:opacity-100' }}" viewBox="0 0 750 500">
                            <rect width="750" height="500" fill="#aa151b"/>
                            <rect width="750" height="250" y="125" fill="#f1bf00"/>
                        </svg>
                    </a>
                </div>

                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-xs font-mono font-bold text-[#d9ff00] hover:text-white transition uppercase italic border border-[#d9ff00]/30 px-4 py-2 rounded-md">
                            {{ Auth::user()->is_admin ? 'CONSOLE' : 'My Studio' }}
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-xs font-mono uppercase italic font-bold text-white hover:text-[#d9ff00] transition">{{ __('messages.menu.login') }}</a>
                    @endauth
                @endif
            </div>

            <!-- BOTTONE HAMBURGER MOBILE -->
            <div class="flex md:hidden">
                <button @click="open = !open" 
                        type="button" 
                        class="text-white hover:text-[#d9ff00] focus:outline-none p-2 relative z-50 bg-transparent" 
                        aria-label="Toggle menu">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="open" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
        
        <!-- PANNELLO MOBILE INTEGRATO -->
        <div x-show="open" 
             x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             @click.away="open = false"
             class="absolute top-full left-0 w-full bg-[#0a0a0a] border-b border-white/10 z-40 md:hidden font-mono text-xs uppercase font-bold italic tracking-widest">
            
            <div class="px-6 pt-4 pb-6 space-y-4 flex flex-col bg-black">
                <a href="{{ route('project') }}" @click="open = false" class="py-2 border-b border-white/5 {{ request()->routeIs('project') ? 'text-[#d9ff00]' : 'text-white' }} hover:text-[#d9ff00]">PROJECT</a>
                <a href="{{ route('artists.index') }}" @click="open = false" class="py-2 border-b border-white/5 {{ request()->routeIs('artists.*') ? 'text-[#d9ff00]' : 'text-white' }} hover:text-[#d9ff00]">ARTISTS</a>
                <a href="{{ route('playlists.index') }}" @click="open = false" class="py-2 border-b border-white/5 {{ request()->routeIs('playlists.*') ? 'text-[#d9ff00]' : 'text-white' }} hover:text-[#d9ff00]">PLAYLIST</a>
                <a href="{{ route('tracks.index') }}" @click="open = false" class="py-2 border-b border-white/5 {{ request()->routeIs('tracks.*') ? 'text-[#d9ff00]' : 'text-white' }} hover:text-[#d9ff00]">TRACKS</a>
                <a href="{{ route('news.index') }}" @click="open = false" class="py-2 border-b border-white/5 {{ request()->routeIs('news.*') ? 'text-[#d9ff00]' : 'text-white' }} hover:text-[#d9ff00]">NEWS</a>
                
                <div class="pt-4 flex flex-col gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}" @click="open = false" class="text-[#d9ff00] py-2 flex items-center justify-between border-t border-white/10">
                            <span>{{ Auth::user()->is_admin ? 'CONSOLE' : 'MY STUDIO' }}</span>
                            <span>⚡</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" @click="open = false" class="text-white py-2 border-t border-white/10">LOGIN</a>
                    @endauth

                    <div class="pt-4 border-t border-white/10 flex items-center justify-between">
                        <span class="text-zinc-500 text-[10px]">LANGUAGE</span>
                        <div class="flex items-center gap-3">
                            <a href="{{ route('lang.switch', 'it') }}" title="Italiano">
                                <svg class="w-6 h-4 rounded-sm overflow-hidden border {{ app()->getLocale() == 'it' ? 'border-[#00FF66]' : 'border-white/20 opacity-60' }}" viewBox="0 0 3 2">
                                    <rect width="1" height="2" fill="#008C45"/><rect x="1" width="1" height="2" fill="#F4F5F0"/><rect x="2" width="1" height="2" fill="#CD212A"/>
                                </svg>
                            </a>
                            <a href="{{ route('lang.switch', 'en') }}" title="English">
                                <svg class="w-6 h-4 rounded-sm overflow-hidden border {{ app()->getLocale() == 'en' ? 'border-[#00FF66]' : 'border-white/20 opacity-60' }}" viewBox="0 0 60 30">
                                    <rect width="60" height="30" fill="#012169"/><path d="M0,0 L60,30 M60,0 L0,30" stroke="#fff" stroke-width="6"/><path d="M30,0 v30 M0,15 h60" stroke="#fff" stroke-width="10"/>
                                </svg>
                            </a>
                            <a href="{{ route('lang.switch', 'es') }}" title="Español">
                                <svg class="w-6 h-4 rounded-sm overflow-hidden border {{ app()->getLocale() == 'es' ? 'border-[#00FF66]' : 'border-white/20 opacity-60' }}" viewBox="0 0 750 500">
                                    <rect width="750" height="500" fill="#aa151b"/><rect width="750" height="250" y="125" fill="#f1bf00"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- PUNTO DI INIEZIONE DEL CONTENUTO -->
    <main class="pb-24">
        @yield('content')
    </main>

    <!-- LIVEWIRE PLAYER PERSISTENTE GLOBALE -->
    @livewire('player')

    <!-- FOOTER (Senza lingue) -->
    <footer class="bg-[#050505] py-12 border-t border-white/5 font-mono">
        <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row items-center justify-between gap-4 text-gray-500 text-xs tracking-widest uppercase">
            <div>
                &copy; {{ date('Y') }} <a href="https://rude-hz.it" class="text-[#00FF66] hover:text-white transition">Rude-Hz Community</a> - Coded by <a href="https://fabioteck.it" class="text-[#00FF66] hover:text-white transition">FabioTeck</a>
            </div>
            <div>
                <a href="{{ route('support') }}" class="text-[#00FF66] hover:text-white transition font-bold">SUPPORT RUDE-HZ →</a>
            </div>
        </div>
    </footer>

    <!-- 80S ARCADE SPACE BACKGROUND CANVAS ANIMATION SCRIPT -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const canvas = document.getElementById('network-canvas');
            if (!canvas) return;
            const ctx = canvas.getContext('2d');

            let width, height;
            let stars = [];
            let invaders = [];
            let ufo = { x: -50, y: 80, speed: 1.2 };
            let astronaut = { x: 80, y: 150 };
            let mouse = { x: null, y: null, radius: 180 };

            const fluoColors = ['#00FF66', '#FF007F', '#9D00FF', '#E6FF00'];

            function resize() {
                width = canvas.width = window.innerWidth;
                height = canvas.height = window.innerHeight;

                stars = [];
                const count = Math.min(Math.floor((width * height) / 12000), 100);
                for (let i = 0; i < count; i++) {
                    stars.push({
                        x: Math.random() * width,
                        y: Math.random() * height,
                        size: Math.random() * 2 + 0.5,
                        color: fluoColors[Math.floor(Math.random() * fluoColors.length)],
                        alpha: Math.random(),
                        pulse: Math.random() * 0.02 + 0.005
                    });
                }

                invaders = [];
                const rows = 2;
                const cols = 5;
                for (let r = 0; r < rows; r++) {
                    for (let c = 0; c < cols; c++) {
                        invaders.push({
                            baseX: c * 50 + 60,
                            baseY: r * 40 + 70,
                            color: fluoColors[(r + c) % fluoColors.length]
                        });
                    }
                }
            }

            window.addEventListener('resize', resize);
            resize();

            window.addEventListener('mousemove', (e) => {
                mouse.x = e.clientX;
                mouse.y = e.clientY;
            });

            window.addEventListener('mouseleave', () => {
                mouse.x = null;
                mouse.y = null;
            });

            function animate() {
                ctx.clearRect(0, 0, width, height);

                // 1. Stelle fluo reattive al mouse
                stars.forEach(star => {
                    star.alpha += star.pulse;
                    if (star.alpha > 1 || star.alpha < 0.2) star.pulse *= -1;

                    let dx = mouse.x !== null ? mouse.x - star.x : 0;
                    let dy = mouse.y !== null ? mouse.y - star.y : 0;
                    let dist = Math.sqrt(dx * dx + dy * dy);
                    if (mouse.x !== null && dist < mouse.radius) {
                        star.x -= (dx / dist) * 0.4;
                        star.y -= (dy / dist) * 0.4;
                    }

                    ctx.beginPath();
                    ctx.arc(star.x, star.y, star.size, 0, Math.PI * 2);
                    ctx.fillStyle = star.color;
                    ctx.globalAlpha = star.alpha;
                    ctx.shadowColor = star.color;
                    ctx.shadowBlur = 6;
                    ctx.fill();
                    ctx.globalAlpha = 1.0;
                    ctx.shadowBlur = 0;
                });

                // 2. Luna retrò 80s
                ctx.save();
                let moonX = width - 100, moonY = 100, moonR = 40;
                let moonGrad = ctx.createRadialGradient(moonX - 10, moonY - 10, 5, moonX, moonY, moonR);
                moonGrad.addColorStop(0, '#E6FF00');
                moonGrad.addColorStop(0.7, '#FF007F');
                moonGrad.addColorStop(1, '#9D00FF');
                ctx.fillStyle = moonGrad;
                ctx.shadowColor = '#FF007F';
                ctx.shadowBlur = 15;
                ctx.beginPath();
                ctx.arc(moonX, moonY, moonR, 0, Math.PI * 2);
                ctx.fill();
                ctx.restore();

                // 3. UFO fluttuante
                ufo.x += ufo.speed;
                if (ufo.x > width + 80) ufo.x = -80;
                ctx.save();
                ctx.fillStyle = '#00FF66';
                ctx.shadowColor = '#00FF66';
                ctx.shadowBlur = 10;
                ctx.beginPath();
                ctx.ellipse(ufo.x, ufo.y + Math.sin(Date.now() * 0.004) * 6, 26, 8, 0, 0, Math.PI * 2);
                ctx.fill();
                ctx.fillStyle = '#FF007F';
                ctx.beginPath();
                ctx.arc(ufo.x, ufo.y - 3 + Math.sin(Date.now() * 0.004) * 6, 10, Math.PI, 0, false);
                ctx.fill();
                ctx.restore();

                // 4. Space Invaders flottanti
                let time = Date.now() * 0.001;
                let wave = Math.sin(time) * 30;
                invaders.forEach((inv, i) => {
                    let cx = inv.baseX + wave;
                    let cy = inv.baseY + Math.cos(time + i) * 4;
                    ctx.fillStyle = inv.color;
                    ctx.shadowColor = inv.color;
                    ctx.shadowBlur = 5;
                    ctx.fillRect(cx, cy, 5, 5);
                    ctx.fillRect(cx + 10, cy, 5, 5);
                    ctx.fillRect(cx + 3, cy + 5, 9, 5);
                    ctx.fillRect(cx, cy + 10, 15, 5);
                    ctx.shadowBlur = 0;
                });

                // 5. Astronauta fluttuante
                astronaut.x += Math.sin(Date.now() * 0.0009) * 0.2;
                astronaut.y += Math.cos(Date.now() * 0.0007) * 0.2;
                ctx.save();
                ctx.translate((width * 0.1) + astronaut.x, (height * 0.5) + astronaut.y);
                ctx.fillStyle = '#9D00FF';
                ctx.shadowColor = '#00FF66';
                ctx.shadowBlur = 8;
                ctx.fillRect(-8, -12, 16, 20);
                ctx.fillStyle = '#E6FF00';
                ctx.beginPath();
                ctx.arc(0, -15, 8, 0, Math.PI * 2);
                ctx.fill();
                ctx.restore();

                requestAnimationFrame(animate);
            }
            animate();
        });
    </script>

</body>
</html>

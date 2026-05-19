<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rude-Hz.it</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0a0a0a] text-white">

    <!-- NAVIGAZIONE -->
   <nav class="sticky top-0 z-50 bg-[#0a0a0a]/80 backdrop-blur-md border-b border-white/10">
        <div class="max-w-7xl mx-auto px-4 h-20 flex justify-between items-center">
            <!-- Logo con link alla Home -->
            <a href="{{ route('home') }}" class="text-2xl font-black text-[#d9ff00]">Rude-Hz.it</a>
            
            <div class="hidden md:flex space-x-8 uppercase text-xs tracking-widest font-bold">
                <!-- Link alle sezioni della Home (funzionano da qualsiasi pagina) -->
                <a href="{{ route('home') }}#news" class="hover:text-[#d9ff00] transition">News</a>
                <a href="{{ route('home') }}#artisti" class="hover:text-[#d9ff00] transition">Artisti</a>
                <a href="{{ route('home') }}#tracks" class="hover:text-[#d9ff00] transition">Tracce</a>
                <!-- Link Rotta Dinamica Contest -->
                <a href="{{ route('contests.index') }}" 
                class="hover:text-[#d9ff00] transition {{ request()->routeIs('contests.*') ? 'text-[#d9ff00]' : '' }}">
                    Contest
                </a>
                <!-- 
                <a href="{{ route('home') }}#contatti" class="hover:text-[#d9ff00] transition">Contatti</a>
                -->
            
            </div>


            <div>
                @if (Route::has('login'))
                    @auth
                        {{-- Il link alla dashboard reindirizza automaticamente in base al ruolo grazie alla logica che abbiamo messo nel web.php --}}
                        <a href="{{ route('dashboard') }}" class="text-sm font-bold text-[#d9ff00] hover:text-white transition">
                            {{ Auth::user()->is_admin ? 'CONSOLE' : 'My Studio' }}
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold mr-4 text-white hover:text-[#d9ff00] transition">Login</a>
                        <a href="{{ route('register') }}" class="bg-[#d9ff00] text-black px-4 py-2 rounded-full text-sm font-bold hover:bg-white transition shadow-[0_0_15px_rgba(217,255,0,0.3)]">
                            Join Us
                        </a>
                    @endauth
                @endif
            </div>
        </div>
    </nav>


    <!-- PUNTO DI INIEZIONE DEL CONTENUTO -->
    <main>
        @yield('content')
    </main>

    <!-- FOOTER IDENTICO PER TUTTI -->
    <footer class="bg-[#050505] py-12 border-t border-white/5">
        <div class="max-w-7xl mx-auto px-4 text-center text-gray-500 text-xs tracking-widest uppercase">
            &copy; {{ date('Y') }} <a href="https://www.rude-hz.it" class="text-[#d9ff00] hover:text-white transition"> Rude-Hz Community</a> - Developed by <a href="https://www.fabioteck.it" class="text-[#d9ff00] hover:text-white transition">FabioTeck</a> with <span class="text-red-500">❤</span>
        </div>
    </footer>

</body>
</html>

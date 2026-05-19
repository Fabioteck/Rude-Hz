<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rude-Hz ADMIN</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f3f4f6] antialiased">
    <!-- TOP NAVIGATION (BIANCA) -->
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                
                <!-- Logo -->
                <div class="flex items-center shrink-0">
                    <a href="{{ route('admin.dashboard') }}" class="text-lg font-black tracking-tighter uppercase text-black">
                        Rude-Hz <span class="bg-gray-100 text-gray-400 text-[10px] px-2 py-0.5 rounded ml-1 font-bold">ADMIN</span>
                    </a>
                </div>

                <!-- Menu Orizzontale (Come da screenshot) -->
                <div class="hidden md:flex space-x-8 uppercase text-[11px] font-bold tracking-widest">
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'text-black border-b-2 border-black' : 'text-gray-400 hover:text-black' }} py-5 transition-colors">Dashboard</a>
                    <a href="{{ route('admin.artists.index') }}" class="{{ request()->is('admin/artists*') ? 'text-black border-b-2 border-black' : 'text-gray-400 hover:text-black' }} py-5 transition-colors">Artisti</a>
                    <a href="{{ route('admin.radio.archive') }}" class="{{ request()->routeIs('admin.radio.archive') ? 'text-black border-b-2 border-black' : 'text-gray-400 hover:text-black' }} py-5 transition-colors">Tracce</a>
                    <a href="{{ route('admin.radio.playlist') }}" class="{{ request()->routeIs('admin.radio.playlist') ? 'text-black border-b-2 border-black' : 'text-gray-400 hover:text-black' }} py-5 transition-colors">Playlist</a>
                    <a href="{{ route('admin.contests.index') }}" class="{{ request()->is('admin/contests*') ? 'text-black border-b-2 border-black' : 'text-gray-400 hover:text-black' }} py-5 transition-colors">Contest</a>
                    <a href="{{ route('admin.news.index') }}" class="{{ request()->is('admin/news*') ? 'text-black border-b-2 border-black' : 'text-gray-400 hover:text-black' }} py-5 transition-colors">News</a>
                </div>

                <!-- Info Utente & Esci -->
                <div class="flex items-center space-x-4">
                    <span class="text-[10px] font-black uppercase tracking-widest text-gray-400">{{ Auth::user()->name }} ADMIN</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-[10px] font-black uppercase tracking-widest text-red-600 hover:text-red-800">Esci</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- AREA CONTENUTO CENTRALE -->
    <main class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{ $slot }}
        </div>
    </main>
</body>
</html>

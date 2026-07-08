<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rude-Hz ADMIN | Studio</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased text-gray-900">

    <!-- CLEAN WHITE ADMIN NAV -->
    <nav class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                
                <!-- Logo -->
                <div class="flex items-center shrink-0">
                    <a href="{{ route('admin.dashboard') }}" class="text-lg font-bold text-gray-800 tracking-tight">
                        RUDE-HZ <span class="text-xs font-normal text-gray-400">ADMIN</span>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-6 items-center">
                    @php
                        $links = [
                            ['route' => 'admin.dashboard', 'label' => 'Dashboard'],
                            ['route' => 'admin.artists.index', 'label' => 'Artisti', 'match' => 'admin/artists*'],
                            ['route' => 'admin.radio.archive', 'label' => 'Tracce'],
                            ['route' => 'admin.playlists.index', 'label' => 'Playlist', 'match' => 'admin/playlists*'],
                            ['route' => 'admin.contests.index', 'label' => 'Contest', 'match' => 'admin/contests*'],
                            ['route' => 'admin.news.index', 'label' => 'News', 'match' => 'admin/news*'],
                            ['route' => 'admin.stats.index', 'label' => 'Statistiche', 'match' => 'admin/stats*'],
                        ];
                    @endphp

                    @foreach($links as $link)
                        <a href="{{ route($link['route']) }}" 
                           class="text-xs font-bold uppercase tracking-widest transition-colors 
                           {{ (isset($link['match']) ? request()->is($link['match']) : request()->routeIs($link['route'])) 
                              ? 'text-gray-900' : 'text-gray-400 hover:text-gray-900' }}">
                            {{ $link['label'] }}
                        </a>
                    @endforeach
                </div>

                <!-- User & Logout -->
                <div class="flex items-center">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold uppercase text-xs tracking-wider px-4 py-2 rounded transition-colors">
                            Esci
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- CONTENT AREA -->
    <main class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{ $slot }}
        </div>
    </main>
</body>
</html>

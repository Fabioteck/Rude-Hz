<!DOCTYPE html>
<html lang="it" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Rude-Hz STUDIO | Artist Area</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0A0A0A] font-sans antialiased text-gray-100 min-h-screen">

    <!-- DARK CYBER-TECH STUDIO NAV -->
    <nav class="bg-[#121212] border-b border-[#1F1F1F] sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                
                <!-- Logo -->
                <div class="flex items-center shrink-0">
                    <a href="{{ route('user.studio') }}" class="text-sm font-black text-white tracking-widest uppercase italic flex items-center space-x-2">
                        <span>RUDE-HZ</span>
                        <span class="text-[10px] bg-[#E6FF00] text-black px-1.5 py-0.5 rounded font-mono font-bold">STUDIO</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="flex space-x-6 items-center font-mono">
                    @php
                        $links = [
                            ['route' => 'user.studio', 'label' => 'Profilo', 'match' => 'my-studio'],
                            ['route' => 'user.tracks.index', 'label' => 'Le Mie Tracce', 'match' => 'my-studio/tracks*'],
                            ['route' => 'user.contests.index', 'label' => 'Contest', 'match' => 'my-studio/contests*'],
                        ];
                    @endphp

                    @foreach($links as $link)
                        <a href="{{ route($link['route']) }}" 
                           class="text-[11px] font-bold uppercase tracking-widest transition-colors 
                           {{ request()->routeIs($link['route']) || (isset($link['match']) && request()->is($link['match'])) 
                              ? 'text-[#E6FF00] border-b-2 border-[#E6FF00] pb-1' : 'text-zinc-400 hover:text-white' }}">
                            {{ $link['label'] }}
                        </a>
                    @endforeach
                </div>

                <!-- User Email Badge & Logout -->
                <div class="flex items-center gap-3">
                    <span class="border border-[#00FF66]/40 text-[#00FF66] px-2.5 py-1 rounded text-[10px] font-mono hidden sm:inline-block">{{ auth()->user()->email }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-zinc-900 border border-red-500/30 hover:bg-red-600 text-red-400 hover:text-white font-mono font-bold uppercase text-[10px] tracking-wider px-3 py-1.5 rounded transition-colors">
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

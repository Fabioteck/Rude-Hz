<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Rude-Hz ADMIN | Cyber Studio</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0A0A0A] font-sans antialiased text-gray-100 min-h-screen">

    <!-- DARK CYBER-TECH ADMIN NAV -->
    <nav x-data="{ open: false }" class="bg-[#121212] border-b border-[#1F1F1F] sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                
                <!-- Logo -->
                <div class="flex items-center shrink-0">
                    <a href="{{ route('admin.dashboard') }}" class="text-sm font-black text-white tracking-widest uppercase italic flex items-center space-x-2">
                        <span>RUDE-HZ</span>
                        <span class="text-[10px] bg-[#E6FF00] text-black px-1.5 py-0.5 rounded font-mono font-bold">ADMIN</span>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-6 items-center font-mono">
                    @php
                        $user = auth()->user();
                        if ($user && $user->role === 'editor') {
                            $links = [
                                ['route' => 'admin.dashboard', 'label' => 'Dashboard'],
                                ['route' => 'admin.contests.index', 'label' => 'Contest', 'match' => 'admin/contests*'],
                                ['route' => 'admin.news.index', 'label' => 'News', 'match' => 'admin/news*'],
                                ['route' => 'admin.pages.index', 'label' => 'PAGES', 'match' => 'admin/pages*'],
                            ];
                        } else {
                            $links = [
                                ['route' => 'admin.dashboard', 'label' => 'Dashboard'],
                                ['route' => 'admin.artists.index', 'label' => 'Artisti', 'match' => 'admin/artists*'],
                                ['route' => 'admin.radio.archive', 'label' => 'Tracce'],
                                ['route' => 'admin.playlists.index', 'label' => 'Playlist', 'match' => 'admin/playlists*'],
                                ['route' => 'admin.contests.index', 'label' => 'Contest', 'match' => 'admin/contests*'],
                                ['route' => 'admin.news.index', 'label' => 'News', 'match' => 'admin/news*'],
                                ['route' => 'admin.pages.index', 'label' => 'PAGES', 'match' => 'admin/pages*'],
                                ['route' => 'admin.stats.index', 'label' => 'STATS', 'match' => 'admin/stats*'],
                            ];
                            if ($user && $user->role === 'super_admin') {
                                $links[] = ['route' => 'admin.users.index', 'label' => 'USERS', 'match' => 'admin/users*'];
                            }
                        }
                    @endphp

                    @foreach($links as $link)
                        <a href="{{ route($link['route']) }}" 
                           class="text-[11px] font-bold uppercase tracking-widest transition-colors 
                           {{ (isset($link['match']) ? request()->is($link['match']) : request()->routeIs($link['route'])) 
                              ? 'text-[#E6FF00] border-b-2 border-[#E6FF00] pb-1' : 'text-zinc-400 hover:text-white' }}">
                            {{ $link['label'] }}
                        </a>
                    @endforeach
                </div>

                <!-- User, Guide, Logout & Mobile Hamburger -->
                <div class="flex items-center gap-2 md:gap-3">
                    <x-admin-guide />
                    <span class="border border-[#00FF66]/40 text-[#00FF66] px-2 py-1 rounded text-[10px] font-mono max-w-[120px] truncate" title="{{ auth()->user()->email }}">{{ auth()->user()->email }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-zinc-900 border border-red-500/30 hover:bg-red-600 text-red-400 hover:text-white font-mono font-bold uppercase text-[9px] tracking-wider px-2 py-1 rounded transition-colors">
                            Esci
                        </button>
                    </form>

                    <!-- Hamburger Mobile Button -->
                    <div class="flex md:hidden ml-1">
                        <button @click="open = !open" 
                                type="button" 
                                class="text-white hover:text-[#E6FF00] focus:outline-none p-1 bg-transparent" 
                                aria-label="Toggle menu">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path x-show="open" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Dropdown Panel -->
        <div x-show="open" 
             x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             @click.away="open = false"
             class="absolute top-full left-0 w-full bg-[#121212] border-b border-[#1F1F1F] z-40 md:hidden font-mono text-xs uppercase font-bold tracking-wider">
            <div class="px-6 py-4 space-y-3 flex flex-col">
                @foreach($links as $link)
                    <a href="{{ route($link['route']) }}" 
                       @click="open = false"
                       class="py-2 border-b border-white/5 {{ (isset($link['match']) ? request()->is($link['match']) : request()->routeIs($link['route'])) ? 'text-[#E6FF00]' : 'text-zinc-300' }} hover:text-[#E6FF00]">
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </div>
        </div>
    </nav>

    <!-- CONTENT AREA -->
    <main class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{ $slot }}
        </div>
    </main>

    <script>
        function toggleActive(btn, url) {
            fetch(url, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const isActive = data.is_active;
                    if (isActive) {
                        btn.className = "px-3 py-1 bg-green-500/20 text-[#E6FF00] border border-[#E6FF00]/40 rounded text-[10px] font-mono font-bold uppercase tracking-wider transition hover:bg-green-500/30";
                        btn.innerText = "ON ⚡";
                    } else {
                        btn.className = "px-3 py-1 bg-zinc-800 text-zinc-400 border border-zinc-700 rounded text-[10px] font-mono font-bold uppercase tracking-wider transition hover:bg-zinc-700";
                        btn.innerText = "OFF 💤";
                    }
                }
            })
            .catch(err => console.error('Error toggling active state:', err));
        }
    </script>
</body>
</html>

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
    <nav class="bg-[#121212] border-b border-[#1F1F1F] sticky top-0 z-50">
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
                            ];
                        } else {
                            $links = [
                                ['route' => 'admin.dashboard', 'label' => 'Dashboard'],
                                ['route' => 'admin.artists.index', 'label' => 'Artisti', 'match' => 'admin/artists*'],
                                ['route' => 'admin.radio.archive', 'label' => 'Tracce'],
                                ['route' => 'admin.playlists.index', 'label' => 'Playlist', 'match' => 'admin/playlists*'],
                                ['route' => 'admin.contests.index', 'label' => 'Contest', 'match' => 'admin/contests*'],
                                ['route' => 'admin.news.index', 'label' => 'News', 'match' => 'admin/news*'],
                                ['route' => 'admin.stats.index', 'label' => 'Statistiche', 'match' => 'admin/stats*'],
                            ];
                            if ($user && $user->role === 'super_admin') {
                                $links[] = ['route' => 'admin.users.index', 'label' => 'Utenti', 'match' => 'admin/users*'];
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

                <!-- User, Guide & Logout -->
                <div class="flex items-center gap-3">
                    <x-admin-guide />
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

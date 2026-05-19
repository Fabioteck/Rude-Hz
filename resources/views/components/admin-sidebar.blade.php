<aside class="w-64 bg-white border-r border-gray-200 h-screen flex flex-col sticky top-0">
    
    <!-- Logo -->
    <div class="p-6 border-b border-gray-100">
        <h2 class="text-black font-bold tracking-tighter text-xl uppercase italic">
            Rude-Hz Admin
        </h2>
    </div>

    <!-- Navigazione -->
    <nav class="flex-1 overflow-y-auto p-4 space-y-6">
        
        <!-- Gruppo Radio -->
        <div>
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3 px-2">Radio Control</p>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('admin.radio.archive') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-100 hover:text-black rounded-md">
                        Tracce & Archivio
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.radio.playlist') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-100 hover:text-black rounded-md">
                        Playlist Player
                    </a>
                </li>
            </ul>
        </div>

        <!-- Gruppo Community -->
        <div>
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3 px-2">Community</p>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('admin.artists.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-100 hover:text-black rounded-md">
                        Artisti
                    </a>
                </li>
            </ul>
        </div>

        <!-- Gruppo Editoriale -->
        <div>
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3 px-2">Editoriale</p>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('admin.news.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-100 hover:text-black rounded-md">
                        News Desk
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.contests.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-100 hover:text-black rounded-md">
                        Contest
                    </a>
                </li>
            </ul>
        </div>

    </nav>

    <!-- Utente (Fondo) -->
    <div class="p-4 border-t border-gray-100 bg-gray-50">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded bg-black text-white flex items-center justify-center font-bold text-xs uppercase">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-bold text-black truncate">{{ Auth::user()->name }}</p>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-red-600 hover:underline text-[10px] font-bold uppercase tracking-tight">Esci</button>
                </form>
            </div>
        </div>
    </div>
</aside>

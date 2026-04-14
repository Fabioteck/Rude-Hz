<aside class="w-64 bg-black border-r border-lime-900/30 h-screen flex flex-col sticky top-0">
    <div class="p-6 border-b border-lime-900/20">
        <h2 class="text-lime-400 font-bold tracking-tighter text-xl italic">RUDE-HZ_CONSOLE</h2>
        <p class="text-[10px] text-gray-500 uppercase tracking-widest">System Status: Online</p>
    </div>

    <nav class="flex-1 overflow-y-auto p-4 space-y-8">
        
        <!-- GRUPPO: RADIO CONTROL -->
        <div>
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4 px-2">Radio Control</h3>
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('admin.radio.moderation') }}" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-300 hover:bg-lime-900/20 hover:text-lime-400 rounded-md transition-all border border-transparent hover:border-lime-900/50">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 19V5l12 7-12 7z"></path></svg>
                        Moderazione
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.radio.archive') }}" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-300 hover:bg-lime-900/20 hover:text-lime-400 rounded-md transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 7v10c0 2 1 3 3 3h10c2 0 3-1 3-3V7c0-2-1-3-3-3H7C5 4 4 5 4 7z"></path></svg>
                        Archivio Tracce
                    </a>
                </li>
            </ul>
        </div>

        <!-- GRUPPO: COMMUNITY -->
        <div>
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4 px-2">Community</h3>
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('admin.community.artists') }}" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-300 hover:bg-lime-900/20 hover:text-lime-400 rounded-md transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M9 7a4 4 0 100-8 4 4 0 000 8z"></path></svg>
                        Artisti (LN/Nostr)
                    </a>
                </li>
            </ul>
        </div>

        <!-- GRUPPO: EDITORIALE -->
        <div>
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4 px-2">Editoriale</h3>
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('admin.news.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-300 hover:bg-lime-900/20 hover:text-lime-400 rounded-md transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2z"></path></svg>
                        News Desk
                    </a>
                </li>
            </ul>
        </div>

    </nav>

    <!-- USER SECTION BOTTOM -->
    <div class="p-4 border-t border-lime-900/20 bg-gray-950">
        <div class="flex items-center gap-3 px-2 py-1">
            <div class="w-8 h-8 rounded-full bg-lime-400 text-black flex items-center justify-center font-bold text-xs">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div class="text-xs">
                <p class="text-gray-200 font-medium">{{ Auth::user()->name }}</p>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-lime-600 hover:text-lime-400 uppercase text-[9px] tracking-tighter">Terminate Session</button>
                </form>
            </div>
        </div>
    </div>
</aside>

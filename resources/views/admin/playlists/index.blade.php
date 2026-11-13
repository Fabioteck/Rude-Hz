<x-admin-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-white">
        
        <!-- Intestazione & Ricerca -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4 border-b border-[#1F1F1F] pb-6">
            <div>
                <h2 class="text-3xl font-black uppercase italic tracking-tight text-white">Gestione Playlist Dinamiche</h2>
                <p class="text-[10px] font-mono text-[#E6FF00] uppercase tracking-widest mt-1">[Admin Panel] Playlist Operative</p>
            </div>
            
            <div class="flex items-center gap-4 w-full md:w-auto">
                <form method="GET" action="{{ route('admin.playlists.index') }}" class="flex-1 md:flex-initial">
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cerca playlist..." 
                           class="bg-[#121212] border border-[#1F1F1F] text-xs font-mono text-white px-4 py-2.5 rounded-lg focus:border-[#E6FF00] outline-none w-full md:w-64">
                </form>
                <a href="{{ route('admin.playlists.create') }}" class="bg-[#E6FF00] text-black px-6 py-2.5 rounded-lg text-xs font-black uppercase tracking-widest hover:bg-white transition shrink-0 shadow-[0_0_20px_rgba(230,255,0,0.2)]">
                    + Crea Nuova Playlist
                </a>
            </div>
        </div>

        <!-- Tabella Cyber-Tech -->
        <div class="bg-[#121212] rounded-xl border border-[#1F1F1F] overflow-hidden shadow-2xl">
            <table class="w-full text-left border-collapse font-mono text-xs">
                <thead>
                    <tr class="border-b border-[#1F1F1F] uppercase text-[10px] font-black text-zinc-500 tracking-[0.2em] bg-[#1A1A1A]/40">
                        <th class="px-6 py-4">Cover</th>
                        <th class="px-6 py-4">Titolo / Descrizione</th>
                        <th class="px-6 py-4 text-right">Console</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1F1F1F]">
                    @forelse($playlists as $playlist)
                    <tr class="hover:bg-[#1A1A1A]/30 transition">
                        <!-- Cover -->
                        <td class="px-6 py-4">
                            <div class="w-16 h-16 rounded-lg bg-[#1A1A1A] border border-[#1F1F1F] overflow-hidden shrink-0">
                                <img src="{{ $playlist->cover_path ? asset('storage/'.$playlist->cover_path) : \App\Services\ImageOptimizerService::placeholderUrl() }}" 
                                     class="w-full h-full object-cover"
                                     onerror="this.onerror=null; this.src='{{ \App\Services\ImageOptimizerService::placeholderUrl() }}';">
                            </div>
                        </td>
                        <!-- Titolo / Descrizione -->
                        <td class="px-6 py-4">
                            <div class="text-sm font-black text-white uppercase">{{ $playlist->title }}</div>
                            <div class="text-[10px] font-mono text-zinc-400 uppercase tracking-tighter mt-1">{{ Str::limit($playlist->description, 60) }}</div>
                        </td>
                        <!-- Console Azioni -->
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end items-center space-x-2">
                                <a href="{{ route('admin.playlists.edit', $playlist) }}" class="flex items-center text-[10px] font-mono font-black uppercase bg-zinc-900 border border-zinc-700 text-white px-3 py-1.5 rounded hover:border-[#E6FF00] hover:text-[#E6FF00] transition-colors">
                                    Edit ✍️
                                </a>
                                <form action="{{ route('admin.playlists.destroy', $playlist) }}" method="POST" onsubmit="return confirm('Eliminare questa playlist?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="flex items-center text-[10px] font-mono font-black uppercase bg-zinc-900 border border-red-500/30 text-red-400 px-3 py-1.5 rounded hover:bg-red-600 hover:text-white transition-colors">
                                        Del 🗑️
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-12 text-center text-zinc-500 font-mono uppercase text-xs">
                            Nessuna playlist creata.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginazione -->
        @if(method_exists($playlists, 'links') && $playlists->hasPages())
        <div class="flex justify-center mt-6">
            <div class="bg-[#121212] border border-[#1F1F1F] rounded-lg p-3 font-mono text-xs">
                {{ $playlists->links() }}
            </div>
        </div>
        @endif
    </div>
</x-admin-layout>

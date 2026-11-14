<x-admin-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-white">
        
        <!-- Intestazione & Ricerca -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4 border-b border-[#1F1F1F] pb-6">
            <div>
                <h2 class="text-3xl font-black uppercase italic tracking-tight text-white">Archivio & Moderazione Tracce</h2>
                <p class="text-[10px] font-mono text-[#E6FF00] uppercase tracking-widest mt-1">[Admin Panel] Gestione Tracce Audio</p>
            </div>
            
            <div class="flex items-center gap-4 w-full md:w-auto">
                <form method="GET" action="{{ route('admin.radio.archive') }}" class="flex-1 md:flex-initial">
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cerca titolo o artista..." 
                           class="bg-[#121212] border border-[#1F1F1F] text-xs font-mono text-white px-4 py-2.5 rounded-lg focus:border-[#E6FF00] outline-none w-full md:w-64">
                </form>
            </div>
        </div>

        <!-- Tabella Cyber-Tech -->
        <div class="bg-[#121212] rounded-xl border border-[#1F1F1F] overflow-hidden shadow-2xl">
            <table class="w-full text-left border-collapse font-mono text-xs">
                <thead>
                    <tr class="border-b border-[#1F1F1F] uppercase text-[10px] font-black text-zinc-500 tracking-[0.2em] bg-[#1A1A1A]/40">
                        <th class="px-6 py-4">Cover</th>
                        <th class="px-6 py-4">Titolo / Artista</th>
                        <th class="px-6 py-4 text-center">Stato (Live)</th>
                        <th class="px-6 py-4 text-center">Moderazione</th>
                        <th class="px-6 py-4 text-right">Console</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1F1F1F]">
                    @forelse($tracks as $track)
                    <tr class="hover:bg-[#1A1A1A]/30 transition">
                        <!-- Cover -->
                        <td class="px-6 py-4">
                            <div class="w-12 h-12 rounded-lg bg-[#1A1A1A] border border-[#1F1F1F] overflow-hidden shrink-0">
                                <img src="{{ $track->cover_path ? asset('storage/'.$track->cover_path) : \App\Services\ImageOptimizerService::placeholderUrl() }}" 
                                     class="w-full h-full object-cover"
                                     onerror="this.onerror=null; this.src='{{ \App\Services\ImageOptimizerService::placeholderUrl() }}';">
                            </div>
                        </td>
                        <!-- Titolo / Artista -->
                        <td class="px-6 py-4">
                            <div class="text-sm font-black text-white uppercase">{{ $track->title }}</div>
                            <div class="text-[10px] font-bold text-zinc-500 uppercase tracking-tighter mt-0.5">{{ $track->artist->name ?? 'Indipendente' }}</div>
                        </td>
                        <!-- Stato Live Toggle -->
                        <td class="px-6 py-4 text-center">
                            <button type="button" 
                                    onclick="toggleActive(this, '{{ route('admin.radio.tracks.toggle-active', $track) }}')"
                                    class="px-3 py-1 rounded text-[10px] font-mono font-bold uppercase tracking-wider transition {{ $track->is_active ? 'bg-green-500/20 text-[#E6FF00] border border-[#E6FF00]/40 hover:bg-green-500/30' : 'bg-zinc-800 text-zinc-400 border border-zinc-700 hover:bg-zinc-700' }}">
                                {!! $track->is_active ? 'ON ⚡' : 'OFF 💤' !!}
                            </button>
                        </td>
                        <!-- Moderazione -->
                        <td class="px-6 py-4 text-center">
                            @if($track->is_approved)
                                <span class="px-2.5 py-1 bg-green-500/20 text-[#E6FF00] border border-[#E6FF00]/40 rounded text-[9px] font-mono uppercase font-bold">Approvata</span>
                            @else
                                <span class="px-2.5 py-1 bg-orange-500/20 text-orange-400 border border-orange-500/40 rounded text-[9px] font-mono uppercase font-bold">In Coda</span>
                            @endif
                        </td>
                        <!-- Console Azioni -->
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end items-center space-x-2">
                                <a href="{{ route('admin.radio.tracks.edit', $track) }}" class="flex items-center text-[10px] font-mono font-black uppercase bg-zinc-900 border border-zinc-700 text-[#E6FF00] px-3 py-1.5 rounded hover:border-[#E6FF00] transition-colors">
                                    Edit ✏️
                                </a>
                                <form action="{{ route('admin.radio.approve', $track) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="flex items-center text-[10px] font-mono font-black uppercase bg-zinc-900 border border-zinc-700 text-white px-3 py-1.5 rounded hover:border-[#E6FF00] hover:text-[#E6FF00] transition-colors">
                                        {{ $track->is_approved ? 'Revoke 🛑' : 'Approve ✅' }}
                                    </button>
                                </form>
                                <form action="{{ route('admin.radio.destroy', $track) }}" method="POST" onsubmit="return confirm('Eliminare definitivamente questa traccia?');">
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
                        <td colspan="5" class="px-6 py-12 text-center text-zinc-500 font-mono uppercase text-xs">
                            Nessuna traccia trovata nell'archivio.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginazione -->
        @if(method_exists($tracks, 'links') && $tracks->hasPages())
        <div class="flex justify-center mt-6">
            <div class="bg-[#121212] border border-[#1F1F1F] rounded-lg p-3 font-mono text-xs">
                {{ $tracks->links() }}
            </div>
        </div>
        @endif
    </div>
</x-admin-layout>

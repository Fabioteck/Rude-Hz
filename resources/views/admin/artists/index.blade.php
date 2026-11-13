<x-admin-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-white">
        
        <!-- Intestazione & Ricerca -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4 border-b border-[#1F1F1F] pb-6">
            <div>
                <h2 class="text-3xl font-black uppercase italic tracking-tight text-white">Anagrafica Artisti</h2>
                <p class="text-[10px] font-mono text-[#E6FF00] uppercase tracking-widest mt-1">[Admin Panel] Gestione Artisti & Tech Stack</p>
            </div>
            
            <div class="flex items-center gap-4 w-full md:w-auto">
                <form method="GET" action="{{ route('admin.artists.index') }}" class="flex-1 md:flex-initial">
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cerca artista o stile..." 
                           class="bg-[#121212] border border-[#1F1F1F] text-xs font-mono text-white px-4 py-2.5 rounded-lg focus:border-[#E6FF00] outline-none w-full md:w-64">
                </form>
                <a href="{{ route('admin.artists.create') }}" class="bg-[#E6FF00] text-black px-6 py-2.5 rounded-lg text-xs font-black uppercase tracking-widest hover:bg-white transition shrink-0 shadow-[0_0_20px_rgba(230,255,0,0.2)]">
                    + Nuovo Artista
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-500/10 border border-green-500/30 text-[#E6FF00] p-4 rounded-xl text-xs uppercase tracking-wider font-mono">
                {{ session('success') }}
            </div>
        @endif

        @if(session('warning'))
            <div class="mb-6 bg-yellow-500/10 border border-yellow-500/30 text-yellow-400 p-4 rounded-xl text-xs uppercase tracking-wider font-mono">
                {{ session('warning') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-500/10 border border-red-500/30 text-red-400 p-4 rounded-xl text-xs uppercase tracking-wider font-mono">
                {{ session('error') }}
            </div>
        @endif

        <!-- Tabella Cyber-Tech -->
        <div class="bg-[#121212] rounded-xl border border-[#1F1F1F] overflow-hidden shadow-2xl">
            <table class="w-full text-left border-collapse font-mono text-xs">
                <thead>
                    <tr class="border-b border-[#1F1F1F] uppercase text-[10px] font-black text-zinc-500 tracking-[0.2em] bg-[#1A1A1A]/40">
                        <th class="px-6 py-4">Artista</th>
                        <th class="px-6 py-4 text-center">Stato (Live)</th>
                        <th class="px-6 py-4">Tech Stack (Nostr/LN)</th>
                        <th class="px-6 py-4 text-right">Console</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1F1F1F]">
                    @forelse($artists as $artist)
                    <tr class="hover:bg-[#1A1A1A]/30 transition">
                        <!-- Colonna Artista -->
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 rounded-lg bg-[#1A1A1A] border border-[#1F1F1F] overflow-hidden shrink-0">
                                    <img src="{{ $artist->photo ? asset('storage/'.$artist->photo) : ($artist->profile_image ? asset('storage/'.$artist->profile_image) : \App\Services\ImageOptimizerService::placeholderUrl()) }}" 
                                         class="w-full h-full object-cover"
                                         onerror="this.onerror=null; this.src='{{ \App\Services\ImageOptimizerService::placeholderUrl() }}';">
                                </div>
                                <div>
                                    <div class="text-sm font-black text-white uppercase">{{ $artist->name }}</div>
                                    <div class="text-[10px] font-bold text-zinc-500 uppercase tracking-tighter">{{ $artist->style ?? 'DEFAULT' }}</div>
                                </div>
                            </div>
                        </td>

                        <!-- Stato Toggle -->
                        <td class="px-6 py-4 text-center">
                            <button type="button" 
                                    onclick="toggleActive(this, '{{ route('admin.artists.toggle-active', $artist) }}')"
                                    class="px-3 py-1 rounded text-[10px] font-mono font-bold uppercase tracking-wider transition {{ $artist->is_active ? 'bg-green-500/20 text-[#E6FF00] border border-[#E6FF00]/40 hover:bg-green-500/30' : 'bg-zinc-800 text-zinc-400 border border-zinc-700 hover:bg-zinc-700' }}">
                                {!! $artist->is_active ? 'ON ⚡' : 'OFF 💤' !!}
                            </button>
                        </td>

                        <!-- Tech Stack -->
                        <td class="px-6 py-4">
                            <div class="flex items-center text-[11px] font-bold text-white">
                                <span class="text-zinc-500 mr-2 uppercase">N</span> {{ Str::limit($artist->nostr_npub, 15) ?: 'N/A' }}
                            </div>
                            <div class="text-[9px] font-black text-zinc-500 uppercase tracking-tighter mt-0.5">LN: {{ $artist->ln_address ? 'Configured' : 'None' }}</div>
                        </td>

                        <!-- Console Azioni -->
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end items-center space-x-2">
                                <a href="{{ route('admin.artists.edit', $artist) }}" class="flex items-center text-[10px] font-mono font-black uppercase bg-zinc-900 border border-zinc-700 text-white px-3 py-1.5 rounded hover:border-[#E6FF00] hover:text-[#E6FF00] transition-colors">
                                    Edit ✍️
                                </a>
                                <form action="{{ route('admin.artists.destroy', $artist) }}" method="POST" onsubmit="return confirm('Eliminare questo artista?');">
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
                        <td colspan="4" class="px-6 py-12 text-center text-zinc-500 font-mono uppercase text-xs">
                            Nessun artista trovato.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginazione -->
        @if(method_exists($artists, 'links') && $artists->hasPages())
        <div class="flex justify-center mt-6">
            <div class="bg-[#121212] border border-[#1F1F1F] rounded-lg p-3 font-mono text-xs">
                {{ $artists->links() }}
            </div>
        </div>
        @endif
    </div>
</x-admin-layout>

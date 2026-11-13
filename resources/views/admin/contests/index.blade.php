<x-admin-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-white">
        
        <!-- Intestazione & Ricerca -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4 border-b border-[#1F1F1F] pb-6">
            <div>
                <h2 class="text-3xl font-black uppercase italic tracking-tight text-white">Gestione Contest</h2>
                <p class="text-[10px] font-mono text-[#E6FF00] uppercase tracking-widest mt-1">[Admin Panel] Contest & Submission</p>
            </div>
            
            <div class="flex items-center gap-4 w-full md:w-auto">
                <form method="GET" action="{{ route('admin.contests.index') }}" class="flex-1 md:flex-initial">
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cerca contest..." 
                           class="bg-[#121212] border border-[#1F1F1F] text-xs font-mono text-white px-4 py-2.5 rounded-lg focus:border-[#E6FF00] outline-none w-full md:w-64">
                </form>
                <a href="{{ route('admin.contests.create') }}" class="bg-[#E6FF00] text-black px-6 py-2.5 rounded-lg text-xs font-black uppercase tracking-widest hover:bg-white transition shrink-0 shadow-[0_0_20px_rgba(230,255,0,0.2)]">
                    + Nuovo Contest
                </a>
            </div>
        </div>

        <!-- Tabella Cyber-Tech Contest -->
        <div class="bg-[#121212] rounded-xl border border-[#1F1F1F] overflow-hidden shadow-2xl mb-12">
            <table class="w-full text-left border-collapse font-mono text-xs">
                <thead>
                    <tr class="border-b border-[#1F1F1F] uppercase text-[10px] font-black text-zinc-500 tracking-[0.2em] bg-[#1A1A1A]/40">
                        <th class="px-6 py-4">Contest</th>
                        <th class="px-6 py-4 text-center">Iscritti</th>
                        <th class="px-6 py-4 text-center">Stato</th>
                        <th class="px-6 py-4 text-right">Console</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1F1F1F]">
                    @forelse($contests as $contest)
                    <tr class="hover:bg-[#1A1A1A]/30 transition">
                        <!-- Contest -->
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 rounded-lg bg-[#1A1A1A] border border-[#1F1F1F] overflow-hidden shrink-0">
                                    <img src="{{ $contest->image_path ? asset('storage/'.$contest->image_path) : \App\Services\ImageOptimizerService::placeholderUrl() }}" 
                                         class="w-full h-full object-cover"
                                         onerror="this.onerror=null; this.src='{{ \App\Services\ImageOptimizerService::placeholderUrl() }}';">
                                </div>
                                <div>
                                    <div class="text-sm font-black text-white uppercase">{{ $contest->title }}</div>
                                    <div class="text-[10px] font-mono text-zinc-500 uppercase tracking-tighter">{{ $contest->slug }}</div>
                                </div>
                            </div>
                        </td>

                        <!-- Iscritti -->
                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 bg-blue-500/20 text-blue-400 border border-blue-500/30 rounded text-[10px] font-mono font-bold uppercase">
                                {{ $contest->tracks_count }} Tracce
                            </span>
                        </td>

                        <!-- Stato -->
                        <td class="px-6 py-4 text-center">
                            @if($contest->is_active)
                                <span class="px-3 py-1 bg-green-500/20 text-[#E6FF00] border border-[#E6FF00]/40 rounded text-[10px] font-mono font-bold uppercase">Attivo</span>
                            @else
                                <span class="px-3 py-1 bg-zinc-800 text-zinc-400 border border-zinc-700 rounded text-[10px] font-mono font-bold uppercase">Off</span>
                            @endif
                        </td>

                        <!-- Console Azioni -->
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end items-center space-x-2">
                                <a href="{{ route('admin.contests.edit', $contest) }}" class="flex items-center text-[10px] font-mono font-black uppercase bg-zinc-900 border border-zinc-700 text-white px-3 py-1.5 rounded hover:border-[#E6FF00] hover:text-[#E6FF00] transition-colors">
                                    Edit ✍️
                                </a>
                                <form action="{{ route('admin.contests.destroy', $contest) }}" method="POST" onsubmit="return confirm('Eliminare questo contest?');">
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
                            Nessun contest attivo.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginazione -->
        @if(method_exists($contests, 'links') && $contests->hasPages())
        <div class="flex justify-center mb-12">
            <div class="bg-[#121212] border border-[#1F1F1F] rounded-lg p-3 font-mono text-xs">
                {{ $contests->links() }}
            </div>
        </div>
        @endif
    </div>
</x-admin-layout>

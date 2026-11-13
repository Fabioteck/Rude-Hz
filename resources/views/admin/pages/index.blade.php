<x-admin-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-white font-mono">
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 border-b border-white/10 pb-6 gap-4">
            <div>
                <h2 class="text-3xl font-black uppercase italic tracking-tight text-white">Gestione Pagine Statiche</h2>
                <p class="text-[10px] font-mono text-[#d9ff00] uppercase tracking-widest mt-1">[Admin Panel] Progetto, Supporto & Info</p>
            </div>
        </div>

        <div class="bg-zinc-950 border border-white/10 rounded-md overflow-hidden shadow-2xl backdrop-blur-md">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="border-b border-white/10 text-zinc-500 uppercase tracking-widest bg-zinc-900/60">
                        <th class="px-6 py-4">Slug / Sezione</th>
                        <th class="px-6 py-4">Titolo</th>
                        <th class="px-6 py-4">Ultimo Aggiornamento</th>
                        <th class="px-6 py-4 text-right">Console</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($pages as $page)
                    <tr class="bg-zinc-900/20 hover:bg-zinc-900/80 transition">
                        <td class="px-6 py-4 font-bold text-[#d9ff00] uppercase">
                            /{{ $page->slug }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-white uppercase tracking-tight">{{ $page->title }}</div>
                            <div class="text-[10px] text-zinc-400 truncate max-w-md">{{ $page->subtitle }}</div>
                        </td>
                        <td class="px-6 py-4 text-zinc-400 text-[10px]">
                            {{ $page->updated_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.pages.edit', $page) }}" class="inline-flex items-center px-3 py-1.5 bg-zinc-900 border border-white/20 text-white rounded-sm text-[10px] font-mono uppercase tracking-wider hover:border-[#d9ff00] hover:text-[#d9ff00] transition">
                                Edit ✍️
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-zinc-600 italic uppercase">
                            Nessuna pagina statica trovata.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-admin-layout>

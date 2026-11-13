<x-admin-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-white">
        
        <!-- Intestazione & Ricerca -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 border-b border-white/10 pb-6 gap-4">
            <div>
                <h2 class="text-3xl font-black uppercase italic tracking-tight text-white">Gestione Redazione</h2>
                <p class="text-[10px] font-mono text-[#d9ff00] uppercase tracking-widest mt-1">[Admin Panel] Articoli & News</p>
            </div>
            
            <div class="flex items-center gap-4 w-full md:w-auto">
                <form method="GET" action="{{ route('admin.news.index') }}" class="flex-1 md:flex-initial">
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cerca news..." 
                           class="bg-zinc-950 border border-white/10 text-xs font-mono text-white px-4 py-2.5 rounded-md focus:border-[#d9ff00] outline-none w-full md:w-64">
                </form>
                <a href="{{ route('admin.news.create') }}" class="bg-[#d9ff00] text-black px-6 py-2.5 rounded-md text-xs font-black uppercase tracking-widest hover:bg-white transition shrink-0 shadow-[0_0_20px_rgba(217,255,0,0.2)]">
                    + Crea Nuova News
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            <!-- Colonna Sinistra: Tabella News (3/4) -->
            <div class="lg:col-span-3 space-y-6">
                <div class="bg-zinc-950 border border-white/10 rounded-md overflow-hidden shadow-2xl backdrop-blur-md">
                    <table class="w-full text-left border-collapse font-mono text-xs">
                        <thead>
                            <tr class="border-b border-white/10 text-zinc-500 uppercase tracking-widest bg-zinc-900/60">
                                <th class="px-6 py-4">News</th>
                                <th class="px-6 py-4">Categoria</th>
                                <th class="px-6 py-4 text-right">Console</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($news as $article)
                            <tr class="bg-zinc-900/20 hover:bg-zinc-900/80 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-12 h-12 rounded-sm bg-zinc-900 border border-white/10 overflow-hidden shrink-0">
                                            <img src="{{ $article->image_path ? asset('storage/'.$article->image_path) : \App\Services\ImageOptimizerService::placeholderUrl() }}" 
                                                 class="w-full h-full object-cover"
                                                 onerror="this.onerror=null; this.src='{{ \App\Services\ImageOptimizerService::placeholderUrl() }}';">
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-white uppercase tracking-tight">{{ $article->title }}</div>
                                            <div class="text-[10px] font-mono text-zinc-500 uppercase tracking-tighter mt-0.5">{{ $article->created_at->format('d/m/Y') }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-[9px] font-mono font-bold px-2.5 py-1 rounded-sm uppercase tracking-wider bg-white/5 border border-white/10 text-[#d9ff00]">
                                        {{ $article->category->name ?? 'Senza Categoria' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end items-center space-x-2">
                                        <a href="{{ route('admin.news.edit', $article) }}" class="inline-flex items-center px-3 py-1.5 bg-zinc-900 border border-white/20 text-white rounded-sm text-[10px] font-mono uppercase tracking-wider hover:border-[#d9ff00] hover:text-[#d9ff00] transition">
                                            Edit ✍️
                                        </a>
                                        <form action="{{ route('admin.news.destroy', $article) }}" method="POST" onsubmit="return confirm('Eliminare questa news?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-zinc-900 border border-red-500/30 text-red-400 rounded-sm text-[10px] font-mono uppercase tracking-wider hover:bg-red-500 hover:text-white transition">
                                                Del 🗑️
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-6 py-12 text-center text-zinc-600 italic uppercase font-mono">
                                    Nessuna news pubblicata.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Paginazione -->
                @if(method_exists($news, 'links') && $news->hasPages())
                <div class="flex justify-center pt-4">
                    <div class="bg-zinc-900/60 border border-white/10 rounded-md p-3 backdrop-blur-md font-mono text-xs">
                        {{ $news->links() }}
                    </div>
                </div>
                @endif
            </div>

            <!-- Colonna Destra: Categorie (1/4) -->
            <div class="lg:col-span-1">
                <div class="bg-zinc-950 border border-white/10 rounded-md p-6 backdrop-blur-md space-y-6">
                    <h3 class="text-sm font-black text-white uppercase tracking-widest pb-3 border-b border-white/10">Categorie</h3>
                    
                    <form action="{{ route('admin.news-categories.store') }}" method="POST" class="space-y-3">
                        @csrf
                        <div>
                            <input type="text" name="name" placeholder="Nuova categoria..." required
                                   class="w-full text-xs font-mono uppercase border border-zinc-800 rounded-md bg-zinc-900/60 text-white p-2.5 focus:border-[#d9ff00] outline-none">
                        </div>
                        <button type="submit" class="w-full bg-zinc-900 border border-white/20 text-[#d9ff00] py-2 rounded-md text-xs font-mono uppercase font-bold hover:bg-[#d9ff00] hover:text-black hover:border-[#d9ff00] transition">
                            + Aggiungi Categoria
                        </button>
                    </form>

                    <div class="space-y-2 pt-2">
                        @foreach($categories as $category)
                            <div class="flex justify-between items-center bg-zinc-900/40 border border-white/5 p-2.5 rounded-md text-xs font-mono text-zinc-300">
                                <span class="uppercase truncate">{{ $category->name }}</span>
                                <form action="{{ route('admin.news-categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Eliminare categoria?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300 font-bold p-1">🗑️</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

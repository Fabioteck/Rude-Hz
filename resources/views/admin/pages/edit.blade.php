<x-admin-layout>
    <div class="max-w-4xl mx-auto px-4 py-12 w-full mt-6 bg-zinc-950 text-white rounded-md border border-white/10 shadow-2xl relative overflow-hidden font-mono">
        
        <div class="mb-8 border-b border-white/10 pb-6 flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-black uppercase italic tracking-tight text-white">Modifica Pagina: /{{ $page->slug }}</h2>
                <p class="text-[10px] font-mono text-[#d9ff00] uppercase tracking-widest mt-1">[Admin Redazione] Gestione Contenuto Statico</p>
            </div>
            <a href="{{ route('admin.pages.index') }}" class="text-xs font-mono text-zinc-400 hover:text-[#d9ff00] uppercase transition">← Torna alla lista</a>
        </div>

        <form action="{{ route('admin.pages.update', $page) }}" method="POST" class="space-y-6 text-xs">
            @csrf
            @method('PATCH')

            <!-- Titolo -->
            <div>
                <label for="title" class="block text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-2">Titolo Principale</label>
                <input type="text" name="title" id="title" required value="{{ old('title', $page->title) }}"
                       class="w-full text-sm font-bold border border-zinc-800 rounded-md bg-zinc-900/60 text-white p-3 focus:border-[#d9ff00] focus:ring-1 focus:ring-[#d9ff00] outline-none">
                @error('title') <p class="text-red-400 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Sottotitolo -->
            <div>
                <label for="subtitle" class="block text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-2">Sottotitolo / Tagline</label>
                <input type="text" name="subtitle" id="subtitle" value="{{ old('subtitle', $page->subtitle) }}"
                       class="w-full text-sm font-bold border border-zinc-800 rounded-md bg-zinc-900/60 text-white p-3 focus:border-[#d9ff00] focus:ring-1 focus:ring-[#d9ff00] outline-none">
                @error('subtitle') <p class="text-red-400 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Contenuto / Descrizione -->
            <div>
                <label for="content" class="block text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-2">Contenuto Principale / Manifesto</label>
                <textarea name="content" id="content" rows="12"
                          class="w-full text-sm font-bold border border-zinc-800 rounded-md bg-zinc-900/60 text-white p-3 focus:border-[#d9ff00] focus:ring-1 focus:ring-[#d9ff00] outline-none">{{ old('content', $page->content) }}</textarea>
                @error('content') <p class="text-red-400 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Bottoni Azione -->
            <div class="pt-6 border-t border-white/10 flex justify-between items-center">
                <p class="text-[10px] text-zinc-500 font-mono">Ultima modifica: {{ $page->updated_at->format('d/m/Y H:i') }}</p>
                <button type="submit" class="bg-[#d9ff00] text-black px-8 py-3 rounded-md text-xs font-black uppercase tracking-widest hover:bg-white transition shadow-[0_0_20px_rgba(217,255,0,0.2)]">
                    Salva Modifiche ✅
                </button>
            </div>
        </form>

    </div>
</x-admin-layout>

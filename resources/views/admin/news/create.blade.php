<x-admin-layout>
    <div class="max-w-4xl mx-auto px-4 py-12 w-full mt-6 bg-zinc-950 text-white rounded-md border border-white/10 shadow-2xl relative overflow-hidden">
        
        <div class="mb-8 border-b border-white/10 pb-6 flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-black uppercase italic tracking-tight text-white">Crea Nuova News</h2>
                <p class="text-[10px] font-mono text-[#d9ff00] uppercase tracking-widest mt-1">[Admin Redazione] Inserimento articolo</p>
            </div>
            <a href="{{ route('admin.news.index') }}" class="text-xs font-mono text-zinc-400 hover:text-[#d9ff00] uppercase transition">← Torna alla lista</a>
        </div>
        
        <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 font-mono text-xs">
            @csrf

            <!-- Titolo -->
            <div>
                <label for="title" class="block text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-2">Titolo della News</label>
                <input type="text" name="title" id="title" required value="{{ old('title') }}"
                       class="w-full text-sm font-bold border border-zinc-800 rounded-md bg-zinc-900/60 text-white p-3 focus:border-[#d9ff00] focus:ring-1 focus:ring-[#d9ff00] outline-none"
                       placeholder="Titolo accattivante...">
                @error('title') <p class="text-red-400 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Sottotitolo -->
            <div>
                <label for="subtitle" class="block text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-2">Sottotitolo della News</label>
                <input type="text" name="subtitle" id="subtitle" value="{{ old('subtitle') }}"
                       class="w-full text-sm font-bold border border-zinc-800 rounded-md bg-zinc-900/60 text-white p-3 focus:border-[#d9ff00] focus:ring-1 focus:ring-[#d9ff00] outline-none"
                       placeholder="Un breve riassunto...">
                @error('subtitle') <p class="text-red-400 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Categoria -->
            <div>
                <label for="category_id" class="block text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-2">Categoria della News</label>
                <select name="category_id" id="category_id" required
                        class="w-full text-sm font-bold border border-zinc-800 rounded-md bg-zinc-900/60 text-white p-3 focus:border-[#d9ff00] focus:ring-1 focus:ring-[#d9ff00] outline-none">
                    <option value="" class="bg-zinc-950">Seleziona categoria...</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" class="bg-zinc-950" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id') <p class="text-red-400 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Immagine di Copertina -->
            <div x-data="{ photoPreview: null }">
                <label class="block text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-2">Immagine di Copertina (Max 2MB)</label>
                <div class="flex items-center gap-4">
                    <div class="w-32 h-20 bg-zinc-900 rounded-md border border-zinc-800 flex items-center justify-center overflow-hidden">
                        <template x-if="photoPreview">
                            <img :src="photoPreview" class="object-cover w-full h-full">
                        </template>
                        <template x-if="!photoPreview">
                            <span class="text-zinc-600 text-[10px]">NO IMG</span>
                        </template>
                    </div>
                    <input type="file" name="image" id="image" class="hidden" x-ref="photo"
                           @change="
                                const reader = new FileReader();
                                reader.onload = (e) => { photoPreview = e.target.result; };
                                reader.readAsDataURL($refs.photo.files[0]);
                           ">
                    <button type="button" @click.prevent="$refs.photo.click()" 
                            class="bg-zinc-900 border border-white/10 text-white px-4 py-2.5 rounded-md text-[10px] font-bold uppercase hover:border-[#d9ff00] hover:text-[#d9ff00] transition">
                        Seleziona File
                    </button>
                </div>
                @error('image') <p class="text-red-400 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Contenuto -->
            <div>
                <label for="content" class="block text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-2">Contenuto dell'articolo</label>
                <textarea name="content" id="content" rows="8" required
                          class="w-full text-sm font-bold border border-zinc-800 rounded-md bg-zinc-900/60 text-white p-3 focus:border-[#d9ff00] focus:ring-1 focus:ring-[#d9ff00] outline-none"
                          placeholder="Scrivi qui il corpo della news...">{{ old('content') }}</textarea>
                @error('content') <p class="text-red-400 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Stato Pubblicazione -->
            <div class="flex items-center bg-zinc-900/40 border border-zinc-800 p-4 rounded-md">
                <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', true) ? 'checked' : '' }}
                       class="h-4 w-4 text-[#d9ff00] focus:ring-[#d9ff00] border-zinc-700 rounded bg-zinc-900">
                <label for="is_published" class="ml-3 block text-xs text-white font-bold uppercase">
                    Pubblicata (Visibile immediatamente sul sito pubblico)
                </label>
            </div>

            <!-- Bottone Invia -->
            <div class="pt-6 border-t border-white/10 flex justify-end">
                <button type="submit" class="bg-[#d9ff00] text-black px-8 py-3 rounded-md text-xs font-black uppercase tracking-widest hover:bg-white transition shadow-[0_0_20px_rgba(217,255,0,0.2)]">
                    Pubblica News ⚡
                </button>
            </div>
        </form>

    </div>
</x-admin-layout>

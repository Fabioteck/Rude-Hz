<x-admin-layout>
    <div class="max-w-4xl mx-auto px-4 py-12 w-full mt-6 bg-zinc-950 text-white rounded-md border border-white/10 shadow-2xl relative overflow-hidden">
        
        <div class="mb-8 border-b border-white/10 pb-6 flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-black uppercase italic tracking-tight text-white">Modifica News</h2>
                <p class="text-[10px] font-mono text-[#d9ff00] uppercase tracking-widest mt-1">[Admin Redazione] {{ $news->title }}</p>
            </div>
            <a href="{{ route('admin.news.index') }}" class="text-xs font-mono text-zinc-400 hover:text-[#d9ff00] uppercase transition">← Torna alla lista</a>
        </div>

        <form action="{{ route('admin.news.update', $news) }}" method="POST" enctype="multipart/form-data" class="space-y-6 font-mono text-xs">
            @csrf
            @method('PATCH')

            <!-- Titolo -->
            <div>
                <label for="title" class="block text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-2">Titolo News</label>
                <input type="text" name="title" id="title" required value="{{ old('title', $news->title) }}"
                       class="w-full text-sm font-bold border border-zinc-800 rounded-md bg-zinc-900/60 text-white p-3 focus:border-[#d9ff00] focus:ring-1 focus:ring-[#d9ff00] outline-none">
                @error('title') <p class="text-red-400 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Sottotitolo -->
            <div>
                <label for="subtitle" class="block text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-2">Sottotitolo News</label>
                <input type="text" name="subtitle" id="subtitle" value="{{ old('subtitle', $news->subtitle) }}"
                       class="w-full text-sm font-bold border border-zinc-800 rounded-md bg-zinc-900/60 text-white p-3 focus:border-[#d9ff00] focus:ring-1 focus:ring-[#d9ff00] outline-none">
                @error('subtitle') <p class="text-red-400 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Categoria -->
            <div>
                <label for="category_id" class="block text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-2">Categoria della News</label>
                <select name="category_id" id="category_id" required
                        class="w-full text-sm font-bold border border-zinc-800 rounded-md bg-zinc-900/60 text-white p-3 focus:border-[#d9ff00] focus:ring-1 focus:ring-[#d9ff00] outline-none">
                    <option value="" class="bg-zinc-950">Seleziona categoria...</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" class="bg-zinc-950" {{ old('category_id', $news->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id') <p class="text-red-400 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Immagine di Copertina -->
            <div x-data="{ photoPreview: null }">
                <label class="block text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-2">Immagine di Copertina</label>
                <div class="flex items-center gap-6">
                    <div class="relative w-48 h-28 bg-zinc-900 rounded-md border border-zinc-800 overflow-hidden flex items-center justify-center">
                        <template x-if="photoPreview">
                            <img :src="photoPreview" class="object-cover w-full h-full">
                        </template>
                        <template x-if="!photoPreview">
                            @if($news->image_path)
                                <img src="{{ asset('storage/' . $news->image_path) }}" class="object-cover w-full h-full">
                            @else
                                <span class="text-zinc-600 text-[10px] italic">Nessuna immagine</span>
                            @endif
                        </template>
                    </div>
                    
                    <div>
                        <input type="file" name="image" id="image" class="hidden" x-ref="photo"
                               @change="
                                    const reader = new FileReader();
                                    reader.onload = (e) => { photoPreview = e.target.result; };
                                    reader.readAsDataURL($refs.photo.files[0]);
                               ">
                        <button type="button" @click.prevent="$refs.photo.click()" 
                                class="bg-zinc-900 border border-white/10 text-white px-4 py-2.5 rounded-md text-[10px] font-bold uppercase hover:border-[#d9ff00] hover:text-[#d9ff00] transition">
                            Sostituisci Foto
                        </button>
                        <p class="text-[10px] text-zinc-500 mt-2 italic">Carica una nuova foto solo se vuoi cambiarla.</p>
                    </div>
                </div>
            </div>

            <!-- Contenuto -->
            <div>
                <label for="content" class="block text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-2">Contenuto dell'articolo</label>
                <textarea name="content" id="content" rows="10" required
                          class="w-full text-sm font-bold border border-zinc-800 rounded-md bg-zinc-900/60 text-white p-3 focus:border-[#d9ff00] focus:ring-1 focus:ring-[#d9ff00] outline-none">{{ old('content', $news->content) }}</textarea>
                @error('content') <p class="text-red-400 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Stato Pubblicazione -->
            <div class="flex items-center bg-zinc-900/40 border border-zinc-800 p-4 rounded-md">
                <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', $news->is_published) ? 'checked' : '' }}
                       class="h-4 w-4 text-[#d9ff00] focus:ring-[#d9ff00] border-zinc-700 rounded bg-zinc-900">
                <label for="is_published" class="ml-3 block text-xs text-white font-bold uppercase">
                    Pubblicata (Visibile sul sito pubblico)
                </label>
            </div>

            <!-- Bottoni Azione -->
            <div class="pt-6 border-t border-white/10 flex justify-between items-center">
                <p class="text-[10px] text-zinc-500 font-mono">Creato il: {{ $news->created_at->format('d/m/Y H:i') }}</p>
                <button type="submit" class="bg-[#d9ff00] text-black px-8 py-3 rounded-md text-xs font-black uppercase tracking-widest hover:bg-white transition shadow-[0_0_20px_rgba(217,255,0,0.2)]">
                    Salva Modifiche ✅
                </button>
            </div>
        </form>

    </div>
</x-admin-layout>

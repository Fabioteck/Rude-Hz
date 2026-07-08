<x-admin-layout>
    <div class="max-w-4xl mx-auto px-4 py-8 w-full mt-6 bg-white rounded-lg shadow-sm">
        
        <h2 class="text-2xl font-black text-black uppercase tracking-tight italic mb-8">Crea Nuova News</h2>
        
        <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Titolo -->
            <div>
                <label for="title" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Titolo della News</label>
                <input type="text" name="title" id="title" required value="{{ old('title') }}"
                       class="w-full text-sm font-bold border-gray-100 rounded bg-gray-50 p-3"
                       placeholder="Titolo accattivante...">
                @error('title') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Sottotitolo -->
            <div>
                <label for="subtitle" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Sottotitolo della News</label>
                <input type="text" name="subtitle" id="subtitle" value="{{ old('subtitle') }}"
                       class="w-full text-sm font-bold border-gray-100 rounded bg-gray-50 p-3"
                       placeholder="Un breve riassunto...">
                @error('subtitle') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Categoria -->
            <div>
                <label for="category_id" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Categoria della News</label>
                <select name="category_id" id="category_id" required
                        class="w-full text-sm font-bold border-gray-100 rounded bg-gray-50 p-3">
                    <option value="">Seleziona categoria...</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Immagine di Copertina -->
            <div x-data="{ photoPreview: null }">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Immagine di Copertina (Max 2MB)</label>
                <div class="flex items-center gap-4">
                    <div class="w-32 h-20 bg-gray-50 rounded border-2 border-dashed border-gray-100 flex items-center justify-center overflow-hidden">
                        <template x-if="photoPreview">
                            <img :src="photoPreview" class="object-cover w-full h-full">
                        </template>
                        <template x-if="!photoPreview">
                            <span class="text-gray-300 text-[10px]">NO IMG</span>
                        </template>
                    </div>
                    <input type="file" name="image" id="image" class="hidden" x-ref="photo"
                           @change="
                                const reader = new FileReader();
                                reader.onload = (e) => { photoPreview = e.target.result; };
                                reader.readAsDataURL($refs.photo.files[0]);
                           ">
                    <button type="button" @click.prevent="$refs.photo.click()" 
                            class="bg-gray-100 text-black px-4 py-2 rounded text-[10px] font-black uppercase hover:bg-gray-200">
                        Seleziona File
                    </button>
                </div>
                @error('image') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Contenuto -->
            <div>
                <label for="content" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Contenuto dell'articolo</label>
                <textarea name="content" id="content" rows="8" required
                          class="w-full text-sm font-bold border-gray-100 rounded bg-gray-50 p-3"
                          placeholder="Scrivi qui il corpo della news...">{{ old('content') }}</textarea>
                @error('content') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Bottone Invia -->
            <div class="pt-4 border-t flex justify-end">
                <button type="submit" class="bg-black text-[#d9ff00] px-8 py-3 rounded-full text-[10px] font-black uppercase tracking-widest hover:bg-gray-800 transition">
                    Pubblica News 🚀
                </button>
            </div>
        </form>

    </div>
</x-admin-layout>

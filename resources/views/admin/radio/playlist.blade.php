<x-admin-layout>
    <div class="max-w-4xl mx-auto px-4 py-8 w-full mt-6 bg-white rounded-lg shadow-sm">
        
        <h2 class="text-2xl font-black text-black uppercase tracking-tight italic mb-8">Crea Nuova Playlist Dinamica</h2>
        
        <form action="{{ route('admin.playlists.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Titolo -->
            <div>
                <label for="title" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Titolo della Playlist</label>
                <input type="text" name="title" id="title" required value="{{ old('title') }}"
                       class="w-full text-sm font-bold border-gray-100 rounded bg-gray-50 p-3"
                       placeholder="Es: Techno Selection 2026">
                @error('title') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Descrizione -->
            <div>
                <label for="description" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Descrizione</label>
                <textarea name="description" id="description" rows="3"
                          class="w-full text-sm font-bold border-gray-100 rounded bg-gray-50 p-3"
                          placeholder="Breve descrizione del mood o collettivo...">{{ old('description') }}</textarea>
                @error('description') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Immagine di Copertina -->
            <div x-data="{ photoPreview: null }">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Copertina (Max 2MB)</label>
                <div class="flex items-center gap-4">
                    <div class="w-32 h-32 bg-gray-50 rounded border-2 border-dashed border-gray-100 flex items-center justify-center overflow-hidden">
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

            <!-- Selezione Tracce -->
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Seleziona Tracce</label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2 max-h-60 overflow-y-auto bg-gray-50 p-4 rounded border border-gray-100">
                    @foreach(\App\Models\Track::where('is_approved', true)->with('artist')->get() as $track)
                        <label class="flex items-center space-x-2 text-[11px] font-bold text-gray-700">
                            <input type="checkbox" name="tracks[]" value="{{ $track->id }}" class="rounded text-black focus:ring-0">
                            <span>{{ $track->title }} - {{ $track->artist->name }}</span>
                        </label>
                    @endforeach
                </div>
                @error('tracks') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Bottone Invia -->
            <div class="pt-4 border-t flex justify-end">
                <button type="submit" class="bg-black text-[#d9ff00] px-8 py-3 rounded-full text-[10px] font-black uppercase tracking-widest hover:bg-gray-800 transition">
                    Crea Playlist 🚀
                </button>
            </div>
        </form>

    </div>
</x-admin-layout>

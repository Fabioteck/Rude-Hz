<x-admin-layout>
    <div class="max-w-4xl mx-auto px-4 py-8 w-full mt-6 bg-white rounded-lg shadow-sm">
        
        <h2 class="text-2xl font-black text-black uppercase tracking-tight italic mb-8">Modifica Contest: {{ $contest->title }}</h2>
        
        <form action="{{ route('admin.contests.update', $contest) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PATCH')

            <!-- BLOCCO ALTO: Titolo, Max, URL -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-1">
                    <label for="title" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Titolo Contest</label>
                    <input type="text" name="title" id="title" required value="{{ old('title', $contest->title) }}"
                           class="w-full text-sm font-bold border-gray-100 rounded bg-gray-50 p-3"
                           placeholder="Titolo...">
                </div>
                <div>
                    <label for="max_tracks_per_artist" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Max Tracce/Artista</label>
                    <input type="number" name="max_tracks_per_artist" id="max_tracks_per_artist" required value="{{ old('max_tracks_per_artist', $contest->max_tracks_per_artist) }}"
                           class="w-full text-sm font-bold border-gray-100 rounded bg-gray-50 p-3">
                </div>
                <div>
                    <label for="playlist_url" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">URL Playlist</label>
                    <input type="text" name="playlist_url" id="playlist_url" value="{{ old('playlist_url', $contest->playlist_url) }}"
                           class="w-full text-sm font-bold border-gray-100 rounded bg-gray-50 p-3"
                           placeholder="https://...">
                </div>
            </div>

            <!-- DESCRIZIONE -->
            <div>
                <label for="description" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Descrizione Contest</label>
                <textarea name="description" id="description" rows="5" required
                          class="w-full text-sm font-bold border-gray-100 rounded bg-gray-50 p-3"
                          placeholder="Dettagli del contest...">{{ old('description', $contest->description) }}</textarea>
            </div>

            <!-- LIBERATORIA -->
            <div>
                <label for="legal_disclaimer" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Testo Liberatoria Legale</label>
                <textarea name="legal_disclaimer" id="legal_disclaimer" rows="3" required
                          class="w-full text-sm font-bold border-gray-100 rounded bg-gray-50 p-3"
                          placeholder="Termini legali...">{{ old('legal_disclaimer', $contest->legal_disclaimer) }}</textarea>
            </div>

            <!-- UPLOADS CON ANTEPRIMA -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Immagine Copertina</label>
                    @if($contest->image_path)
                        <img src="{{ asset('storage/' . $contest->image_path) }}" class="h-16 w-16 object-cover rounded mb-2 shadow-sm border border-gray-100">
                    @endif
                    <input type="file" name="image" class="w-full text-xs font-bold border-gray-100 rounded bg-gray-50 p-2">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Regolamento PDF</label>
                    @if($contest->rules_pdf)
                        <div class="mb-2 text-[10px] font-bold text-gray-500 uppercase italic">PDF Attuale presente</div>
                    @endif
                    <input type="file" name="rules_pdf" class="w-full text-xs font-bold border-gray-100 rounded bg-gray-50 p-2">
                </div>
            </div>

            <!-- BOTTONE SALVA E CHECKBOX -->
            <div class="pt-6 border-t flex justify-between items-center">
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $contest->is_active) ? 'checked' : '' }} class="rounded border-gray-300 text-black">
                    <label for="is_active" class="ml-2 text-[10px] font-black text-gray-700 uppercase">Contest Attivo</label>
                </div>
                <button type="submit" class="bg-black text-[#d9ff00] px-8 py-3 rounded-full text-[10px] font-black uppercase tracking-widest hover:bg-gray-800 transition">
                    SALVA MODIFICHE
                </button>
            </div>
        </form>

    </div>
</x-admin-layout>

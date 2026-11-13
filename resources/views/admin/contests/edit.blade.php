<x-admin-layout>
    <div class="max-w-4xl mx-auto px-4 py-12 w-full mt-6 bg-zinc-950 text-white rounded-md border border-white/10 shadow-2xl relative overflow-hidden font-mono">
        
        <div class="mb-8 border-b border-white/10 pb-6 flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-black uppercase italic tracking-tight text-white">Modifica Contest</h2>
                <p class="text-[10px] font-mono text-[#E6FF00] uppercase tracking-widest mt-1">[Admin Panel] {{ $contest->title }}</p>
            </div>
            <a href="{{ route('admin.contests.index') }}" class="text-xs font-mono text-zinc-400 hover:text-[#E6FF00] uppercase transition">← Torna alla lista</a>
        </div>
        
        <form action="{{ route('admin.contests.update', $contest) }}" method="POST" enctype="multipart/form-data" class="space-y-6 text-xs">
            @csrf
            @method('PUT')

            <!-- BLOCCO ALTO: Titolo, Max, URL -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-1">
                    <label for="title" class="block text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-2">Titolo Contest *</label>
                    <input type="text" name="title" id="title" required value="{{ old('title', $contest->title) }}"
                           class="w-full text-sm font-bold border border-zinc-800 rounded-md bg-zinc-900/60 text-white p-3 focus:border-[#E6FF00] focus:ring-1 focus:ring-[#E6FF00] outline-none">
                </div>
                <div>
                    <label for="max_tracks_per_artist" class="block text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-2">Max Tracce/Artista *</label>
                    <input type="number" name="max_tracks_per_artist" id="max_tracks_per_artist" required value="{{ old('max_tracks_per_artist', $contest->max_tracks_per_artist) }}"
                           class="w-full text-sm font-bold border border-zinc-800 rounded-md bg-zinc-900/60 text-white p-3 focus:border-[#E6FF00] outline-none">
                </div>
                <div>
                    <label for="playlist_url" class="block text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-2">URL Playlist</label>
                    <input type="text" name="playlist_url" id="playlist_url" value="{{ old('playlist_url', $contest->playlist_url) }}"
                           class="w-full text-sm font-bold border border-zinc-800 rounded-md bg-zinc-900/60 text-white p-3 focus:border-[#E6FF00] outline-none">
                </div>
            </div>

            <!-- DESCRIZIONE -->
            <div>
                <label for="description" class="block text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-2">Descrizione Contest *</label>
                <textarea name="description" id="description" rows="5" required
                          class="w-full text-sm font-bold border border-zinc-800 rounded-md bg-zinc-900/60 text-white p-3 focus:border-[#E6FF00] outline-none">{{ old('description', $contest->description) }}</textarea>
            </div>

            <!-- LIBERATORIA -->
            <div>
                <label for="legal_disclaimer" class="block text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-2">Testo Liberatoria Legale *</label>
                <textarea name="legal_disclaimer" id="legal_disclaimer" rows="3" required
                          class="w-full text-sm font-bold border border-zinc-800 rounded-md bg-zinc-900/60 text-white p-3 focus:border-[#E6FF00] outline-none">{{ old('legal_disclaimer', $contest->legal_disclaimer) }}</textarea>
            </div>

            <!-- UPLOADS -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-2">Immagine Copertina</label>
                    @if($contest->image_path)
                        <div class="mb-2 w-16 h-16 rounded overflow-hidden border border-zinc-800">
                            <img src="{{ asset('storage/' . $contest->image_path) }}" class="w-full h-full object-cover">
                        </div>
                    @endif
                    <input type="file" name="image" class="w-full text-xs text-zinc-400 border border-zinc-800 rounded-md bg-zinc-900/60 p-3">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-2">Regolamento PDF</label>
                    @if($contest->rules_pdf)
                        <div class="mb-2 text-[10px] text-[#E6FF00] italic">PDF Attuale presente</div>
                    @endif
                    <input type="file" name="rules_pdf" class="w-full text-xs text-zinc-400 border border-zinc-800 rounded-md bg-zinc-900/60 p-3">
                </div>
            </div>

            <!-- BOTTONE SALVA E CHECKBOX -->
            <div class="pt-6 border-t border-white/10 flex justify-between items-center">
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $contest->is_active) ? 'checked' : '' }} class="h-4 w-4 text-[#E6FF00] focus:ring-[#E6FF00] border-zinc-700 rounded bg-zinc-900">
                    <label for="is_active" class="ml-3 text-xs text-white font-bold uppercase">Contest Attivo</label>
                </div>
                <div class="flex gap-4">
                    <a href="{{ route('admin.contests.index') }}" class="px-6 py-3 bg-zinc-900 border border-zinc-700 text-zinc-300 rounded-md text-xs font-bold uppercase hover:bg-zinc-800 transition">Annulla</a>
                    <button type="submit" class="bg-[#E6FF00] text-black px-8 py-3 rounded-md text-xs font-black uppercase tracking-widest hover:bg-white transition shadow-[0_0_20px_rgba(230,255,0,0.2)]">
                        SALVA MODIFICHE
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-admin-layout>

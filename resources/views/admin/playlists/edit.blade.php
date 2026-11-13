<x-admin-layout>
    <div class="max-w-4xl mx-auto px-4 py-12 w-full mt-6 bg-zinc-950 text-white rounded-md border border-white/10 shadow-2xl relative overflow-hidden font-mono">
        
        <div class="mb-8 border-b border-white/10 pb-6 flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-black uppercase italic tracking-tight text-white">Modifica Playlist</h2>
                <p class="text-[10px] font-mono text-[#E6FF00] uppercase tracking-widest mt-1">[Admin Panel] {{ $playlist->title }}</p>
            </div>
            <a href="{{ route('admin.playlists.index') }}" class="text-xs font-mono text-zinc-400 hover:text-[#E6FF00] uppercase transition">← Torna alla lista</a>
        </div>
        
        <form action="{{ route('admin.playlists.update', $playlist) }}" method="POST" enctype="multipart/form-data" class="space-y-6 text-xs">
            @csrf
            @method('PUT')

            <!-- Titolo -->
            <div>
                <label for="title" class="block text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-2">Titolo della Playlist</label>
                <input type="text" name="title" id="title" required value="{{ old('title', $playlist->title) }}"
                       class="w-full text-sm font-bold border border-zinc-800 rounded-md bg-zinc-900/60 text-white p-3 focus:border-[#E6FF00] focus:ring-1 focus:ring-[#E6FF00] outline-none">
                @error('title') <p class="text-red-400 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Descrizione -->
            <div>
                <label for="description" class="block text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-2">Descrizione</label>
                <textarea name="description" id="description" rows="3"
                          class="w-full text-sm font-bold border border-zinc-800 rounded-md bg-zinc-900/60 text-white p-3 focus:border-[#E6FF00] focus:ring-1 focus:ring-[#E6FF00] outline-none">{{ old('description', $playlist->description) }}</textarea>
                @error('description') <p class="text-red-400 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Copertina -->
            <div class="flex items-center gap-6">
                <div class="w-20 h-20 rounded-lg bg-zinc-900 border border-zinc-800 overflow-hidden shrink-0">
                    <img src="{{ $playlist->cover_path ? asset('storage/'.$playlist->cover_path) : \App\Services\ImageOptimizerService::placeholderUrl() }}" class="w-full h-full object-cover">
                </div>
                <div class="flex-1">
                    <label class="block text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-2">Aggiorna Copertina (Max 2MB)</label>
                    <input type="file" name="image" class="w-full text-xs text-zinc-400 border border-zinc-800 rounded-md bg-zinc-900/60 p-3">
                </div>
            </div>

            <!-- Selezione Tracce -->
            <div>
                <label class="block text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-2">Seleziona Tracce</label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2 max-h-60 overflow-y-auto bg-zinc-900/40 p-4 rounded-md border border-zinc-800">
                    @php
                        $selectedTracks = old('tracks', $playlist->tracks->pluck('id')->toArray());
                    @endphp
                    @foreach($tracks as $track)
                        <label class="flex items-center space-x-2 text-[11px] font-bold text-zinc-300 hover:text-white cursor-pointer">
                            <input type="checkbox" name="tracks[]" value="{{ $track->id }}" {{ in_array($track->id, $selectedTracks) ? 'checked' : '' }} class="rounded text-[#E6FF00] focus:ring-0 bg-zinc-900 border-zinc-700">
                            <span class="truncate">{{ $track->title }} - {{ $track->artist->name ?? 'Indipendente' }}</span>
                        </label>
                    @endforeach
                </div>
                @error('tracks') <p class="text-red-400 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Bottoni Azione -->
            <div class="pt-6 border-t border-white/10 flex justify-end gap-4">
                <a href="{{ route('admin.playlists.index') }}" class="px-6 py-3 bg-zinc-900 border border-zinc-700 text-zinc-300 rounded-md text-xs font-bold uppercase hover:bg-zinc-800 transition">Annulla</a>
                <button type="submit" class="bg-[#E6FF00] text-black px-8 py-3 rounded-md text-xs font-black uppercase tracking-widest hover:bg-white transition shadow-[0_0_20px_rgba(230,255,0,0.2)]">
                    Salva Modifiche
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>

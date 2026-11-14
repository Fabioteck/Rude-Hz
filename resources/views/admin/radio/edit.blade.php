<x-admin-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-white py-8">
        
        <!-- Header -->
        <div class="mb-8 border-b border-[#1F1F1F] pb-6 flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-black uppercase italic tracking-tight text-white">Modifica Traccia</h2>
                <p class="text-[10px] font-mono text-[#E6FF00] uppercase tracking-widest mt-1">[Admin Panel] {{ $track->title }}</p>
            </div>
            <a href="{{ route('admin.radio.archive') }}" class="px-4 py-2 bg-zinc-900 border border-[#1F1F1F] text-zinc-300 hover:text-white font-mono text-xs font-bold uppercase rounded-lg transition">
                ← Torna all'Archivio
            </a>
        </div>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-500/20 border border-red-500/50 rounded-lg text-red-400 font-mono text-xs">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.radio.tracks.update', $track) }}" method="POST" enctype="multipart/form-data" class="bg-[#121212] border border-[#1F1F1F] rounded-xl p-6 sm:p-8 space-y-6 shadow-2xl font-mono text-xs">
            @csrf
            @method('PUT')

            <!-- Titolo -->
            <div class="space-y-2">
                <label for="title" class="block uppercase font-bold text-zinc-300 tracking-wider">Titolo Traccia *</label>
                <input type="text" id="title" name="title" value="{{ old('title', $track->title) }}" required
                       class="w-full bg-[#1A1A1A] border border-[#1F1F1F] rounded-lg px-4 py-3 text-white focus:border-[#E6FF00] outline-none">
            </div>

            <!-- Artista Proprietario -->
            <div class="space-y-2">
                <label for="artist_id" class="block uppercase font-bold text-zinc-300 tracking-wider">Artista Proprietario</label>
                <select id="artist_id" name="artist_id" class="w-full bg-[#1A1A1A] border border-[#1F1F1F] rounded-lg px-4 py-3 text-white focus:border-[#E6FF00] outline-none">
                    <option value="">-- Nessun Artista / Indipendente --</option>
                    @foreach($artists as $artist)
                        <option value="{{ $artist->id }}" {{ old('artist_id', $track->artist_id) == $artist->id ? 'selected' : '' }}>
                            {{ $artist->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Genere -->
            <div class="space-y-2">
                <label for="genre" class="block uppercase font-bold text-zinc-300 tracking-wider">Genere Musicale</label>
                <input type="text" id="genre" name="genre" value="{{ old('genre', $track->genre) }}" placeholder="es. Tekno, Acid, Hardcore"
                       class="w-full bg-[#1A1A1A] border border-[#1F1F1F] rounded-lg px-4 py-3 text-white focus:border-[#E6FF00] outline-none">
            </div>

            <!-- Copertina Attuale & Nuova Copertina -->
            <div class="space-y-4 pt-2">
                <label class="block uppercase font-bold text-zinc-300 tracking-wider">Copertina Traccia</label>
                <div class="flex items-center gap-6">
                    <div class="w-20 h-20 rounded-lg bg-[#1A1A1A] border border-[#1F1F1F] overflow-hidden shrink-0">
                        <img src="{{ $track->cover_path ? asset('storage/'.$track->cover_path) : \App\Services\ImageOptimizerService::placeholderUrl() }}" 
                             class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1 space-y-2">
                        <input type="file" name="cover" accept="image/*"
                               class="w-full text-xs text-zinc-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-zinc-800 file:text-[#E6FF00] hover:file:bg-zinc-700 cursor-pointer">
                        <p class="text-[10px] text-zinc-500 uppercase">Formati ammessi: JPG, PNG, WEBP (Max 5MB)</p>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-6 border-t border-[#1F1F1F] flex justify-end gap-4">
                <a href="{{ route('admin.radio.archive') }}" class="px-6 py-3 bg-zinc-900 border border-[#1F1F1F] text-zinc-300 font-bold uppercase rounded-lg hover:bg-zinc-800 transition">
                    Annulla
                </a>
                <button type="submit" class="px-6 py-3 bg-[#E6FF00] text-black font-black uppercase rounded-lg hover:bg-white transition shadow-[0_0_20px_rgba(230,255,0,0.3)]">
                    Salva Modifiche ⚡
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>

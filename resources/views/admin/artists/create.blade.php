<x-admin-layout>
    <div class="max-w-4xl mx-auto px-4 py-12 w-full mt-6 bg-zinc-950 text-white rounded-md border border-white/10 shadow-2xl relative overflow-hidden font-mono">
        
        <div class="mb-8 border-b border-white/10 pb-6 flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-black uppercase italic tracking-tight text-white">Nuovo Artista</h2>
                <p class="text-[10px] font-mono text-[#E6FF00] uppercase tracking-widest mt-1">[Admin Panel] Registrazione Artista & Tech Stack</p>
            </div>
            <a href="{{ route('admin.artists.index') }}" class="text-xs font-mono text-zinc-400 hover:text-[#E6FF00] uppercase transition">← Torna alla lista</a>
        </div>

        <form action="{{ route('admin.artists.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 text-xs">
            @csrf

            <!-- Identità -->
            <div>
                <label for="name" class="block text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-2">Nome Artista *</label>
                <input type="text" name="name" id="name" required value="{{ old('name') }}"
                       class="w-full text-sm font-bold border border-zinc-800 rounded-md bg-zinc-900/60 text-white p-3 focus:border-[#E6FF00] focus:ring-1 focus:ring-[#E6FF00] outline-none uppercase">
                @error('name') <p class="text-red-400 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Stile / Genere -->
            <div>
                <label for="style" class="block text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-2">Stile / Genere</label>
                <input type="text" name="style" id="style" value="{{ old('style') }}" placeholder="es. Techno, Ambient, Experimental..."
                       class="w-full text-sm font-bold border border-zinc-800 rounded-md bg-zinc-900/60 text-white p-3 focus:border-[#E6FF00] focus:ring-1 focus:ring-[#E6FF00] outline-none">
                @error('style') <p class="text-red-400 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Biografia -->
            <div>
                <label for="bio" class="block text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-2">Biografia</label>
                <textarea name="bio" id="bio" rows="4"
                          class="w-full text-sm font-bold border border-zinc-800 rounded-md bg-zinc-900/60 text-white p-3 focus:border-[#E6FF00] focus:ring-1 focus:ring-[#E6FF00] outline-none">{{ old('bio') }}</textarea>
                @error('bio') <p class="text-red-400 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Foto / Avatar -->
            <div>
                <label class="block text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-2">Foto / Cover Profilo</label>
                <input type="file" name="photo" class="w-full text-xs text-zinc-400 border border-zinc-800 rounded-md bg-zinc-900/60 p-3">
                @error('photo') <p class="text-red-400 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Protocolli Satoshi & Nostr -->
            <div class="bg-zinc-900/40 border border-zinc-800 p-6 rounded-md space-y-4">
                <h3 class="text-sm font-black text-[#E6FF00] uppercase tracking-widest">⚡ Protocolli & Mance (Lightning / Nostr)</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-1">Lightning Address (LNURL)</label>
                        <input type="text" name="ln_address" value="{{ old('ln_address') }}" placeholder="user@getalby.com"
                               class="w-full text-xs font-mono border border-zinc-800 rounded-md bg-zinc-900/60 text-white p-2.5 focus:border-[#E6FF00] outline-none">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-1">Nostr Public Key (npub)</label>
                        <input type="text" name="nostr_npub" value="{{ old('nostr_npub') }}" placeholder="npub1..."
                               class="w-full text-xs font-mono border border-zinc-800 rounded-md bg-zinc-900/60 text-white p-2.5 focus:border-[#E6FF00] outline-none">
                    </div>
                </div>
            </div>

            <!-- Social Links -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach(['spotify', 'soundcloud', 'instagram', 'youtube', 'facebook'] as $social)
                    @php $field = $social . '_url'; @endphp
                    <div>
                        <label class="block text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-1">{{ ucfirst($social) }} URL</label>
                        <input type="url" name="{{ $field }}" value="{{ old($field) }}" placeholder="https://..."
                               class="w-full text-xs font-mono border border-zinc-800 rounded-md bg-zinc-900/60 text-white p-2.5 focus:border-[#E6FF00] outline-none">
                    </div>
                @endforeach
            </div>

            <!-- Stato Attivo -->
            <div class="flex items-center bg-zinc-900/40 border border-zinc-800 p-4 rounded-md">
                <input type="checkbox" name="is_active" id="is_active" value="1" checked
                       class="h-4 w-4 text-[#E6FF00] focus:ring-[#E6FF00] border-zinc-700 rounded bg-zinc-900">
                <label for="is_active" class="ml-3 block text-xs text-white font-bold uppercase">
                    Profilo Attivo (Visibile sul portale)
                </label>
            </div>

            <!-- Bottoni Azione -->
            <div class="pt-6 border-t border-white/10 flex justify-end gap-4">
                <a href="{{ route('admin.artists.index') }}" class="px-6 py-3 bg-zinc-900 border border-zinc-700 text-zinc-300 rounded-md text-xs font-bold uppercase hover:bg-zinc-800 transition">Annulla</a>
                <button type="submit" class="bg-[#E6FF00] text-black px-8 py-3 rounded-md text-xs font-black uppercase tracking-widest hover:bg-white transition shadow-[0_0_20px_rgba(230,255,0,0.2)]">
                    + Crea Artista
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>

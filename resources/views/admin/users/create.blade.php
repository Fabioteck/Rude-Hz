<x-admin-layout>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-6 font-mono">
        
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-black text-white uppercase tracking-tight italic">Crea Nuovo Utente</h2>
                <p class="text-xs text-zinc-400 mt-1 uppercase tracking-widest">Aggiungi un membro al team Rude-Hz</p>
            </div>
            <a href="{{ route('admin.users.index') }}" class="text-xs text-zinc-400 hover:text-white uppercase">← Torna alla lista</a>
        </div>

        @if ($errors->any())
            <div class="mb-6 bg-red-500/10 border border-red-500/30 text-red-400 p-4 rounded text-xs uppercase tracking-wider">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-[#121212] border border-[#1F1F1F] rounded-xl p-8 shadow-sm">
            <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-zinc-300 uppercase tracking-widest mb-2">Nome Completo / Nickname</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full bg-zinc-900 border border-[#1F1F1F] text-white text-xs px-4 py-3 rounded focus:outline-none focus:border-[#E6FF00]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-zinc-300 uppercase tracking-widest mb-2">Indirizzo Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="w-full bg-zinc-900 border border-[#1F1F1F] text-white text-xs px-4 py-3 rounded focus:outline-none focus:border-[#E6FF00]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-zinc-300 uppercase tracking-widest mb-2">Password Provvisoria</label>
                    <input type="password" name="password" required class="w-full bg-zinc-900 border border-[#1F1F1F] text-white text-xs px-4 py-3 rounded focus:outline-none focus:border-[#E6FF00]">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-zinc-300 uppercase tracking-widest mb-2">Ruolo Operativo</label>
                        <select name="role" required class="w-full bg-zinc-900 border border-[#1F1F1F] text-white text-xs px-4 py-3 rounded focus:outline-none focus:border-[#E6FF00] uppercase">
                            <option value="artist" {{ old('role') == 'artist' ? 'selected' : '' }}>Artist (Utente Standard)</option>
                            <option value="curator" {{ old('role') == 'curator' ? 'selected' : '' }}>Curator (Moderatore)</option>
                            <option value="editor" {{ old('role') == 'editor' ? 'selected' : '' }}>Editor (Redazione News)</option>
                            <option value="super_admin" {{ old('role') == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-zinc-300 uppercase tracking-widest mb-2">Categoria News Assegnata (Editor)</label>
                        <select name="assigned_category_id" class="w-full bg-zinc-900 border border-[#1F1F1F] text-white text-xs px-4 py-3 rounded focus:outline-none focus:border-[#E6FF00] uppercase">
                            <option value="">-- Nessuna / Tutte --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('assigned_category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="accent-[#E6FF00] w-4 h-4">
                    <label for="is_active" class="text-xs text-zinc-300 uppercase tracking-wider font-bold">Utente Attivo (Abilitato all'accesso)</label>
                </div>

                <div class="pt-6 border-t border-[#1F1F1F] flex justify-end gap-4">
                    <a href="{{ route('admin.users.index') }}" class="px-6 py-3 bg-zinc-900 hover:bg-zinc-800 text-zinc-400 uppercase text-xs rounded transition font-bold">Annulla</a>
                    <button type="submit" class="px-8 py-3 bg-[#E6FF00] text-black font-black hover:bg-white uppercase text-xs rounded transition shadow-[0_0_20px_rgba(230,255,0,0.3)]">Salva Utente</button>
                </div>
            </form>
        </div>

    </div>
</x-admin-layout>

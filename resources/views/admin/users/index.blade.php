<x-admin-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 font-mono">
        
        <!-- HEADER & ACTIONS -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h2 class="text-2xl font-black text-white uppercase tracking-tight italic">Gestione Utenti & Team</h2>
                <p class="text-xs text-zinc-400 mt-1 uppercase tracking-widest">Amministrazione ruoli e permessi staff</p>
            </div>
            <div class="flex items-center gap-4">
                <form method="GET" action="{{ route('admin.users.index') }}" class="flex items-center gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cerca utente..." class="bg-[#121212] border border-[#1F1F1F] text-white text-xs px-3 py-2 rounded focus:outline-none focus:border-[#E6FF00]">
                    <button type="submit" class="bg-zinc-800 hover:bg-zinc-700 text-[#E6FF00] border border-[#1F1F1F] px-4 py-2 rounded text-xs font-bold uppercase tracking-wider transition">Cerca</button>
                </form>
                <a href="{{ route('admin.users.create') }}" class="bg-[#E6FF00] text-black font-black hover:bg-white text-xs px-4 py-2 rounded uppercase tracking-wider transition shadow-[0_0_15px_rgba(230,255,0,0.2)]">
                    + Nuovo Utente
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-500/10 border border-green-500/30 text-[#E6FF00] p-4 rounded text-xs uppercase tracking-wider">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-500/10 border border-red-500/30 text-red-400 p-4 rounded text-xs uppercase tracking-wider">
                {{ session('error') }}
            </div>
        @endif

        <!-- TABELLA UTENTI -->
        <div class="bg-[#121212] border border-[#1F1F1F] rounded-xl overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="border-b border-[#1F1F1F] text-zinc-400 uppercase tracking-widest bg-zinc-900/50">
                            <th class="py-4 px-6">Nome & Email</th>
                            <th class="py-4 px-6">Ruolo</th>
                            <th class="py-4 px-6">Categoria Assegnata</th>
                            <th class="py-4 px-6 text-center">Stato</th>
                            <th class="py-4 px-6 text-center">Registrato il</th>
                            <th class="py-4 px-6 text-right">Azioni</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#1F1F1F]">
                        @forelse($users as $user)
                        <tr class="hover:bg-zinc-900/40 transition-colors">
                            <td class="py-4 px-6">
                                <div class="font-bold text-white uppercase tracking-tight">{{ $user->name }}</div>
                                <div class="text-[10px] text-zinc-400 normal-case">{{ $user->email }}</div>
                            </td>
                            <td class="py-4 px-6 uppercase">
                                <span class="px-2.5 py-1 rounded text-[10px] font-bold 
                                    @if($user->role === 'super_admin') bg-red-500/20 text-red-400 border border-red-500/40
                                    @elseif($user->role === 'editor') bg-yellow-500/20 text-[#E6FF00] border border-[#E6FF00]/40
                                    @elseif($user->role === 'curator') bg-blue-500/20 text-blue-400 border border-blue-500/40
                                    @else bg-zinc-800 text-zinc-400 border border-zinc-700 @endif">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-zinc-400 uppercase">
                                @if($user->assigned_category_id && $cat = \App\Models\NewsCategory::find($user->assigned_category_id))
                                    {{ $cat->name }}
                                @else
                                    <span class="text-zinc-600">—</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center">
                                <button type="button" 
                                        onclick="toggleActive(this, '{{ route('admin.users.toggle-active', $user->id) }}')" 
                                        class="px-3 py-1 rounded text-[10px] font-bold uppercase tracking-wider transition {{ $user->is_active ? 'bg-green-500/20 text-[#E6FF00] border border-[#E6FF00]/40 hover:bg-green-500/30' : 'bg-zinc-800 text-zinc-400 border border-zinc-700 hover:bg-zinc-700' }}">
                                    {{ $user->is_active ? 'ON ⚡' : 'OFF 💤' }}
                                </button>
                            </td>
                            <td class="py-4 px-6 text-center text-zinc-400 text-[11px]">
                                {{ $user->created_at->format('d/m/Y') }}
                            </td>
                            <td class="py-4 px-6 text-right space-x-2">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="inline-block px-3 py-1.5 bg-zinc-800 hover:bg-zinc-700 text-white border border-[#1F1F1F] rounded text-[10px] font-bold uppercase transition">
                                    Modifica
                                </a>
                                @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Eliminare definitivamente questo utente?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 bg-red-900/20 hover:bg-red-600 text-red-400 hover:text-white border border-red-500/30 rounded text-[10px] font-bold uppercase transition">
                                        Elimina
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-16 text-center text-zinc-500 uppercase tracking-widest italic">
                                Nessun utente trovato nell'archivio.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($users->hasPages())
                <div class="p-6 border-t border-[#1F1F1F]">
                    {{ $users->links() }}
                </div>
            @endif
        </div>

    </div>
</x-admin-layout>

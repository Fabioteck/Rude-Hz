<x-admin-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Intestazione Pagina -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-black text-black uppercase tracking-tight italic">Gestione Playlist Dinamiche</h2>
            <a href="{{ route('admin.playlists.create') }}" class="bg-black text-[#d9ff00] px-6 py-2 rounded-full text-[10px] font-black uppercase tracking-widest">+ Crea Nuova Playlist</a>
        </div>

        <!-- Tabella Bianca Playlist -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-50 uppercase text-[9px] font-black text-gray-300 tracking-[0.2em]">
                        <th class="px-8 py-5">Cover</th>
                        <th class="px-8 py-5">Titolo / Descrizione</th>
                        <th class="px-8 py-5 text-right">Console</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($playlists as $playlist)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-8 py-4">
                            <div class="w-16 h-16 rounded-lg bg-gray-100 overflow-hidden">
                                <img src="{{ $playlist->cover_path ? asset('storage/'.$playlist->cover_path) : asset('images/default-playlist.jpg') }}" class="w-full h-full object-cover">
                            </div>
                        </td>
                        <td class="px-8 py-4">
                            <div class="text-sm font-black text-black uppercase">{{ $playlist->title }}</div>
                            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter mt-1">{{ Str::limit($playlist->description, 50) }}</div>
                        </td>
                        <td class="px-8 py-4 text-right">
                            <div class="flex justify-end items-center space-x-2">
                                <form action="{{ route('admin.playlists.destroy', $playlist) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="flex items-center text-[10px] font-black uppercase bg-red-100 text-red-600 px-3 py-1.5 rounded hover:bg-red-200 transition-colors">
                                        Del 🗑️
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-8 py-8 text-center text-gray-500 font-bold uppercase tracking-widest text-xs">
                            Nessuna playlist creata.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>

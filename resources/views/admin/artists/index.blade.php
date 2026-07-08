<x-admin-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Intestazione Pagina -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-black text-black uppercase tracking-tight italic">Anagrafica Artisti Rude-Hz</h2>
            <a href="{{ route('admin.artists.create') }}" class="bg-black text-[#d9ff00] px-6 py-2 rounded-full text-[10px] font-black uppercase tracking-widest">+ Nuovo Artista</a>
        </div>

        <!-- Tabella Bianca -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-50 uppercase text-[9px] font-black text-gray-300 tracking-[0.2em]">
                        <th class="px-8 py-5">Artista</th>
                        <th class="px-8 py-5 text-center">Social Connect</th>
                        <th class="px-8 py-5">Tech Stack (Nostr/LN)</th>
                        <th class="px-8 py-5 text-right">Console</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($artists as $artist)
                    <tr class="hover:bg-gray-50 transition">
                        <!-- Colonna Artista -->
                        <td class="px-8 py-4">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 rounded-lg bg-gray-100 overflow-hidden">
                                    <img src="{{ $artist->photo ? asset('storage/'.$artist->photo) : asset('images/default-avatar.png') }}" 
                                         class="w-full h-full object-cover"
                                         onerror="this.onerror=null; this.src='data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%23cbd5e0%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22><path d=%22M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2%22/><circle cx=%2212%22 cy=%227%22 r=%224%22/></svg>';">
                                </div>
                                <div>
                                    <div class="text-sm font-black text-black uppercase">{{ $artist->name }}</div>
                                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">{{ $artist->style ?? 'DEFAULT' }}</div>
                                </div>
                            </div>
                        </td>

                        <!-- Social -->
                        <td class="px-8 py-4 text-center">
                            <span class="text-gray-200">☁️</span>
                        </td>

                        <!-- Tech Stack -->
                        <td class="px-8 py-4">
                            <div class="flex items-center text-[11px] font-bold text-black">
                                <span class="text-gray-400 mr-2 uppercase">N</span> {{ Str::limit($artist->nostr_npub, 15) }}
                            </div>
                            <div class="text-[9px] font-black text-gray-300 uppercase tracking-tighter mt-0.5">Tips Offline</div>
                        </td>

                        <!-- Console Azioni -->
                        <td class="px-8 py-4 text-right">
                            <div class="flex justify-end items-center space-x-2">
                                <a href="{{ route('admin.artists.edit', $artist) }}" class="flex items-center text-[10px] font-black uppercase bg-orange-100 text-orange-600 px-3 py-1.5 rounded hover:bg-orange-200 transition-colors">
                                    Edit ✍️
                                </a>
                                <form action="{{ route('admin.artists.destroy', $artist) }}" method="POST" onsubmit="return confirm('Sei sicuro?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="flex items-center text-[10px] font-black uppercase bg-red-100 text-red-600 px-3 py-1.5 rounded hover:bg-red-200 transition-colors">
                                        Del 🗑️
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>

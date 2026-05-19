<x-admin-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Intestazione Pagina -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-black text-black uppercase tracking-tight italic">Anagrafica Artisti Rude-Hz</h2>
            <button class="bg-black text-[#d9ff00] px-6 py-2 rounded-full text-[10px] font-black uppercase tracking-widest">+ Nuovo Artista</button>
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
                                    <img src="{{ asset('storage/'.$artist->photo) }}" class="w-full h-full object-cover">
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
                                <span class="text-gray-400 mr-2 uppercase">N</span> {{ Str::limit($artist->nostr_pubkey, 15) }}
                            </div>
                            <div class="text-[9px] font-black text-gray-300 uppercase tracking-tighter mt-0.5">Tips Offline</div>
                        </td>

                        <!-- Console Azioni -->
                        <td class="px-8 py-4 text-right">
                            <div class="flex justify-end items-center space-x-4">
                                <a href="#" class="flex items-center text-[10px] font-black uppercase text-gray-500 border border-gray-100 px-3 py-1.5 rounded hover:bg-gray-50">
                                    Edit ✍️
                                </a>
                                <button class="flex items-center text-[10px] font-black uppercase text-red-400 border border-gray-100 px-3 py-1.5 rounded hover:bg-red-50">
                                    Del 🗑️
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>

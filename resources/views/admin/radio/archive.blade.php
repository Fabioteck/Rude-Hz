<x-admin-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Intestazione Pagina -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-black text-black uppercase tracking-tight italic">Gestione Tracce Caricate</h2>
        </div>

        <!-- Tabella Bianca -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-50 uppercase text-[9px] font-black text-gray-300 tracking-[0.2em]">
                        <th class="px-8 py-5">Cover</th>
                        <th class="px-8 py-5">Titolo / Slug</th>
                        <th class="px-8 py-5">Artista</th>
                        <th class="px-8 py-5 text-center">Stato</th>
                        <th class="px-8 py-5 text-right">Console</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($tracks as $track)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-8 py-4">
                            <div class="w-12 h-12 rounded-lg bg-gray-100 overflow-hidden">
                                <img src="{{ $track->cover_path ? asset('storage/'.$track->cover_path) : asset('images/default-track.jpg') }}" 
                                     class="w-full h-full object-cover"
                                     onerror="this.onerror=null; this.src='data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%23cbd5e0%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22><path d=%22M9 18V5l12-2v13%22/><circle cx=%226%22 cy=%2218%22 r=%223%22/><circle cx=%2218%22 cy=%2216%22 r=%223%22/></svg>';">
                            </div>
                        </td>
                        <td class="px-8 py-4">
                            <div class="text-sm font-black text-black uppercase">{{ $track->title }}</div>
                            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">{{ $track->slug }}</div>
                        </td>
                        <td class="px-8 py-4">
                            <div class="text-sm font-bold text-gray-900">{{ $track->artist->name ?? 'Indipendente' }}</div>
                        </td>
                        <td class="px-8 py-4 text-center">
                            <span class="text-[9px] font-black px-3 py-1 rounded-full uppercase tracking-tighter bg-gray-100 text-gray-600">CARICATA</span>
                        </td>
                        <!-- Console Azioni -->
                        <td class="px-8 py-4 text-right">
                            <div class="flex justify-end items-center space-x-2">
                                <form action="{{ route('admin.radio.destroy', $track) }}" method="POST" onsubmit="return confirm('Sei sicuro? Questa azione eliminerà definitivamente i file.');">
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

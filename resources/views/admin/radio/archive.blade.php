<x-admin-layout>
    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        
        <!-- Header con Titolo e Bottone Carica -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-normal text-gray-800">Gestione Tracce</h2>
            <button class="bg-[#1e293b] text-white px-5 py-2 rounded shadow-sm text-[11px] font-bold uppercase tracking-widest hover:bg-black transition">
                + NUOVA TRACCIA
            </button>
        </div>

        <!-- Card Bianca Contenuti -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-50">
                        <th class="px-8 py-5">Immagine</th>
                        <th class="px-8 py-5">Titolo / Slug</th>
                        <th class="px-8 py-5">Artista</th>
                        <th class="px-8 py-5 text-center">Stato</th>
                        <th class="px-8 py-5 text-right">Azioni</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($tracks as $track)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-8 py-4">
                            <div class="w-16 h-10 bg-gray-100 rounded overflow-hidden">
                                <img src="{{ asset('storage/'.$track->cover_path) }}" class="w-full h-full object-cover" onerror="this.src='/img/placeholder.jpg'">
                            </div>
                        </td>
                        <td class="px-8 py-4">
                            <div class="text-sm font-bold text-gray-900">{{ $track->title }}</div>
                            <div class="text-[10px] text-gray-400">{{ $track->slug }}</div>
                        </td>
                        <td class="px-8 py-4 text-sm text-gray-600">
                            {{ $track->artist->name ?? 'Indipendente' }}
                        </td>
                        <td class="px-8 py-4 text-center">
                            @if($track->is_approved)
                                <span class="text-[10px] font-bold text-green-500 flex items-center justify-center uppercase">
                                    <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span> ATTIVO
                                </span>
                            @else
                                <span class="text-[10px] font-bold text-orange-400 flex items-center justify-center uppercase">
                                    <span class="w-2 h-2 bg-orange-400 rounded-full mr-2"></span> PENDING
                                </span>
                            @endif
                        </td>
                        <td class="px-8 py-4 text-right">
                            <div class="flex justify-end space-x-2 text-[11px] font-bold uppercase">
                                <form action="{{ route('admin.radio.approve', $track) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button class="text-blue-500 hover:text-blue-700">Modifica</button>
                                </form>
                                <form action="{{ route('admin.radio.destroy', $track) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="text-red-500 hover:text-red-700">Elimina</button>
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

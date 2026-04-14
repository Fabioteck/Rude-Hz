<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Archivio Tracce Online') }}
            </h2>
            <a href="{{ route('admin.radio.moderation') }}" class="text-sm text-indigo-600 hover:text-indigo-900 font-medium">
                &larr; Torna alla Moderazione
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stato</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Titolo / Artista</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Caricato il</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Azioni</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($tracks as $track)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($track->is_approved)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                On-Air
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                In Pausa
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <div class="font-bold text-gray-900">{{ $track->title }}</div>
                                        <div class="text-gray-500">{{ $track->artist_name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $track->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                        <!-- Toggle Stato -->
                                        <form action="{{ route('admin.radio.approve', $track) }}" method="POST" class="inline">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="text-indigo-600 hover:text-indigo-900 font-bold" title="Cambia stato">
                                                {{ $track->is_approved ? 'Sospendi' : 'Riattiva' }}
                                            </button>
                                        </form>

                                        <!-- Elimina Definitivo -->
                                        <form action="{{ route('admin.radio.destroy', $track) }}" method="POST" class="inline" onsubmit="return confirm('⚠️ Azione irreversibile: vuoi eliminare il file dal server?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 font-bold">
                                                Elimina
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-400 italic">
                                        L'archivio è vuoto. Approva qualche master dalla moderazione!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $tracks->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Moderazione Tracce') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Titolo / Versione</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Info Artista</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Azioni</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($pendingTracks as $track)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $track->title }}</div>
                                        <div class="text-xs text-indigo-500 font-mono italic">{{ $track->version ?? 'Standard' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-700 font-bold uppercase tracking-tight">
                                            {{ $track->artist_name }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-3">
                                        <!-- Approva (Green Breeze) -->
                                        <form action="{{ route('admin.radio.approve', $track) }}" method="POST" class="inline">
                                            @csrf @method('PATCH')
                                            <x-primary-button class="bg-green-600 hover:bg-green-700 focus:bg-green-700 active:bg-green-800">
                                                {{ __('Approva') }}
                                            </x-primary-button>
                                        </form>

                                        <!-- Elimina (Danger Breeze) -->
                                        <form action="{{ route('admin.radio.destroy', $track) }}" method="POST" class="inline" onsubmit="return confirm('Sicuro di voler cancellare il file dal server?')">
                                            @csrf @method('DELETE')
                                            <x-danger-button>
                                                {{ __('Elimina') }}
                                            </x-danger-button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-12 text-center text-gray-400 italic">
                                        Nessun master in attesa. Il Raspberry sta riposando.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $pendingTracks->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

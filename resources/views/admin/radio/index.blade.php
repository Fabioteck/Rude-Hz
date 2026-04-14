<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Amministrazione') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Grid Standard -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm font-medium text-gray-500 uppercase">Brani in attesa</div>
                    <div class="mt-1 text-3xl font-semibold text-gray-900">{{ $pendingTracksCount }}</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm font-medium text-gray-500 uppercase">Totale Archivio</div>
                    <div class="mt-1 text-3xl font-semibold text-gray-900">{{ $totalTracks }}</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm font-medium text-gray-500 uppercase">Artisti Registrati</div>
                    <div class="mt-1 text-3xl font-semibold text-gray-900">{{ \App\Models\Artist::count() }}</div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Azioni Rapide</h3>
                <div class="flex space-x-4">
                    <x-primary-button onclick="window.location='{{ route('admin.news.create') }}'">
                        {{ __('Nuova News') }}
                    </x-primary-button>
                    <x-secondary-button onclick="window.location='{{ route('admin.artists.create') }}'">
                        {{ __('Nuovo Artista') }}
                    </x-secondary-button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

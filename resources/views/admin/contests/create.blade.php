<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Crea Nuovo Contest</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200">
                
                <form action="{{ route('admin.contests.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <x-input-label for="title" value="Titolo del Contest" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title')" required />
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="max_tracks_per_artist" value="Max Tracce/Artista" />
                                <x-text-input name="max_tracks_per_artist" type="number" :value="old('max_tracks_per_artist', 1)" class="mt-1 block w-full" />
                            </div>
                            <div>
                                <x-input-label for="playlist_url" value="URL Playlist" />
                                <x-text-input name="playlist_url" type="text" :value="old('playlist_url')" class="mt-1 block w-full" placeholder="https://..." />
                            </div>
                        </div>
                    </div>

                    <!-- DESCRIZIONE (Textarea standard per sicurezza) -->
                    <div class="mb-6">
                        <x-input-label for="description" value="Descrizione Contest" />
                        <textarea id="description" name="description" rows="10" 
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" 
                            required>{{ old('description') }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">Puoi usare tag HTML per la formattazione (es: &lt;b&gt;testo&lt;/b&gt;).</p>
                    </div>

                    <!-- LIBERATORIA -->
                    <div class="mb-6">
                        <x-input-label for="legal_disclaimer" value="Testo Liberatoria Legale" />
                        <textarea name="legal_disclaimer" rows="4" 
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" 
                            required>{{ old('legal_disclaimer') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4 bg-gray-50 rounded border border-gray-100">
                        <div>
                            <x-input-label value="Immagine (JPG/PNG)" />
                            <input type="file" name="image" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        </div>
                        <div>
                            <x-input-label value="Regolamento PDF" />
                            <input type="file" name="rules_pdf" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <x-primary-button class="bg-gray-900 text-white px-6 py-2">
                            PUBBLICA CONTEST
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

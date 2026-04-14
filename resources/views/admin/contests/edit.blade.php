<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Modifica Contest: {{ $contest->title }}
            </h2>
            <a href="{{ route('admin.contests.index') }}" class="text-sm text-gray-600 underline hover:text-gray-900 transition">
                &larr; Torna alla lista
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200">
                
                @if ($errors->any())
                    <div class="bg-red-500 text-white p-4 mb-6 rounded shadow-md">
                        <strong>Attenzione!</strong> Ci sono degli errori:<br>
                        <ul class="list-disc ml-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.contests.update', $contest) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Titolo -->
                        <div>
                            <x-input-label for="title" value="Titolo del Contest" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $contest->title)" required />
                        </div>

                        <!-- Playlist & Limite -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="max_tracks_per_artist" value="Max Tracce/Artista" />
                                <x-text-input id="max_tracks_per_artist" name="max_tracks_per_artist" type="number" :value="old('max_tracks_per_artist', $contest->max_tracks_per_artist)" class="mt-1 block w-full" />
                            </div>
                            <div>
                                <x-input-label for="playlist_url" value="URL Playlist" />
                                <x-text-input id="playlist_url" name="playlist_url" type="text" :value="old('playlist_url', $contest->playlist_url)" class="mt-1 block w-full" placeholder="https://..." />
                            </div>
                        </div>
                    </div>

                    <!-- DESCRIZIONE (Textarea Standard per sicurezza) -->
                    <div class="mb-6">
                        <x-input-label for="description" value="Descrizione Contest" />
                        <textarea id="description" name="description" rows="8" 
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" 
                            required>{{ old('description', $contest->description) }}</textarea>
                    </div>

                    <!-- LIBERATORIA -->
                    <div class="mb-6">
                        <x-input-label for="legal_disclaimer" value="Testo Liberatoria Legale" />
                        <textarea id="legal_disclaimer" name="legal_disclaimer" rows="4" 
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" 
                            required>{{ old('legal_disclaimer', $contest->legal_disclaimer) }}</textarea>
                    </div>

                    <!-- UPLOADS CON ANTEPRIMA -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4 bg-gray-50 rounded border border-gray-100 mb-6">
                        <!-- Immagine -->
                        <div>
                            <x-input-label value="Immagine Copertina" />
                            @if($contest->image_path)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $contest->image_path) }}" class="h-20 w-auto rounded shadow-sm border bg-white">
                                    <span class="text-[10px] text-gray-400 italic font-mono">Immagine attuale</span>
                                </div>
                            @endif
                            <input type="file" name="image" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-white file:text-gray-700 hover:file:bg-gray-100">
                        </div>

                        <!-- PDF -->
                        <div>
                            <x-input-label value="Regolamento PDF" />
                            @if($contest->rules_pdf)
                                <div class="mb-2 flex items-center space-x-2">
                                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                    <a href="{{ asset('storage/' . $contest->rules_pdf) }}" target="_blank" class="text-xs text-indigo-600 underline font-bold">Vedi PDF Attuale</a>
                                </div>
                            @endif
                            <input type="file" name="rules_pdf" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-white file:text-gray-700 hover:file:bg-gray-100">
                        </div>
                    </div>

                    <div class="mt-8 flex justify-between items-center">
                        <!-- Stato Attivo -->
                        <div class="flex items-center">
                            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $contest->is_active) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <label for="is_active" class="ml-2 text-sm font-bold text-gray-700 uppercase">Contest Attivo</label>
                        </div>

                        <x-primary-button class="bg-gray-900 px-8">
                            SALVA MODIFICHE
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

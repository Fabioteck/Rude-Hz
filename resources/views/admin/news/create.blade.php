<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crea Nuova News') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 border">
                
                <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Titolo -->
                    <div>
                        <label for="title" class="block text-sm font-bold text-gray-700 uppercase tracking-wider">Titolo della News</label>
                        <input type="text" name="title" id="title" required value="{{ old('title') }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                               placeholder="Inserisci un titolo accattivante...">
                        @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Immagine di Copertina con Preview -->
                    <div x-data="{ photoName: null, photoPreview: null }">
                        <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider">Immagine di Copertina</label>
                        
                        <!-- Preview Box -->
                        <div class="mt-2 flex items-center gap-4">
                            <div class="relative w-40 h-24 bg-gray-100 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center overflow-hidden">
                                <template x-if="photoPreview">
                                    <img :src="photoPreview" class="object-cover w-full h-full">
                                </template>
                                <template x-if="!photoPreview">
                                    <span class="text-gray-400 text-xs">Nessuna immagine</span>
                                </template>
                            </div>
                            
                            <input type="file" name="image" id="image" class="hidden" 
                                   x-ref="photo"
                                   @change="
                                        photoName = $refs.photo.files[0].name;
                                        const reader = new FileReader();
                                        reader.onload = (e) => { photoPreview = e.target.result; };
                                        reader.readAsDataURL($refs.photo.files[0]);
                                   ">
                            
                            <button type="button" @click.prevent="$refs.photo.click()" 
                                    class="bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
                                Seleziona File
                            </button>
                        </div>
                        @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Contenuto (Textarea semplice o predisposta per Editor) -->
                    <div>
                        <label for="content" class="block text-sm font-bold text-gray-700 uppercase tracking-wider">Contenuto dell'articolo</label>
                        <textarea name="content" id="content" rows="10" required
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                  placeholder="Scrivi qui il corpo della news...">{{ old('content') }}</textarea>
                        @error('content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Toggle Pubblicazione -->
                    <div class="flex items-center">
                        <input type="checkbox" name="is_published" id="is_published" value="1" checked
                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="is_published" class="ml-2 block text-sm text-gray-900 font-medium">
                            Pubblica immediatamente su Rude-Hz.it
                        </label>
                    </div>

                    <!-- Bottone Invia -->
                    <div class="pt-4 border-t flex justify-end">
                        <button type="submit" class="bg-black hover:bg-gray-800 text-white font-black py-3 px-8 rounded-full uppercase tracking-tighter transition shadow-lg">
                            Pubblica News 🚀
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Modifica News:') }} <span class="text-indigo-600">{{ $news->title }}</span>
            </h2>
            <a href="{{ route('admin.news.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← Torna alla lista</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 border">
                
                <form action="{{ route('admin.news.update', $news) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <!-- Titolo -->
                    <div>
                        <label for="title" class="block text-sm font-bold text-gray-700 uppercase tracking-wider">Titolo News</label>
                        <input type="text" name="title" id="title" required value="{{ old('title', $news->title) }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Immagine Attuale e Caricamento -->
                    <div x-data="{ photoPreview: null }">
                        <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider">Immagine di Copertina</label>
                        
                        <div class="mt-2 flex items-center gap-6">
                            <!-- Preview Box -->
                            <div class="relative w-48 h-28 bg-gray-100 rounded-lg border overflow-hidden">
                                <template x-if="photoPreview">
                                    <img :src="photoPreview" class="object-cover w-full h-full">
                                </template>
                                <template x-if="!photoPreview">
                                    @if($news->image_path)
                                        <img src="{{ asset('storage/' . $news->image_path) }}" class="object-cover w-full h-full">
                                    @else
                                        <div class="flex items-center justify-center h-full text-gray-400 text-xs text-center p-2 italic">Nessuna immagine impostata</div>
                                    @endif
                                </template>
                            </div>
                            
                            <div>
                                <input type="file" name="image" id="image" class="hidden" x-ref="photo"
                                       @change="
                                            const reader = new FileReader();
                                            reader.onload = (e) => { photoPreview = e.target.result; };
                                            reader.readAsDataURL($refs.photo.files[0]);
                                       ">
                                <button type="button" @click.prevent="$refs.photo.click()" 
                                        class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none transition ease-in-out duration-150">
                                    Sostituisci Foto
                                </button>
                                <p class="text-[10px] text-gray-400 mt-2 italic">Carica una nuova foto solo se vuoi cambiarla.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Contenuto Articolo -->
                    <div>
                        <label for="content" class="block text-sm font-bold text-gray-700 uppercase tracking-wider">Contenuto</label>
                        <textarea name="content" id="content" rows="12" required
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('content', $news->content) }}</textarea>
                    </div>

                    <!-- Stato Pubblicazione -->
                    <div class="flex items-center bg-gray-50 p-4 rounded-lg">
                        <input type="checkbox" name="is_published" id="is_published" value="1" {{ $news->is_published ? 'checked' : '' }}
                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="is_published" class="ml-2 block text-sm text-gray-900 font-bold">
                            Pubblicata (Visibile sul sito)
                        </label>
                    </div>

                    <!-- Bottoni Azione -->
                    <div class="pt-6 border-t flex justify-between items-center">
                        <p class="text-xs text-gray-400 font-mono">Creato il: {{ $news->created_at->format('d/m/Y H:i') }}</p>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-black py-3 px-10 rounded-full uppercase tracking-widest transition shadow-lg">
                            Salva Modifiche ✅
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>

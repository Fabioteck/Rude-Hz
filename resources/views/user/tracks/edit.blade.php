<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight uppercase tracking-widest">
                {{ __('Modifica Traccia') }}
            </h2>
            <a href="{{ route('user.tracks.index') }}" class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 hover:text-black transition-colors">
                &larr; Torna al Catalogo
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-500 text-white text-xs font-bold uppercase rounded-lg shadow-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white border border-gray-200 shadow-sm rounded-xl overflow-hidden">
                <!-- Preview Player in alto -->
                <div class="p-8 bg-gray-50 border-b border-gray-100 flex flex-col items-center space-y-4">
                    <span class="text-[9px] font-black uppercase tracking-[0.3em] text-gray-300">Preview Audio</span>
                    <audio controls class="h-8 w-full max-w-md grayscale opacity-80">
                        <source src="{{ asset('storage/' . $track->file_path) }}" type="audio/mpeg">
                    </audio>
                </div>

                <form action="{{ route('user.track.update', $track->id) }}" method="POST" class="p-8 space-y-8">
                    @csrf
                    @method('PATCH')

                    <!-- 1. INFO PRINCIPALI -->
                    <div class="space-y-6">
                        <h2 class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-400 border-b pb-2">Metadati Traccia</h2>
                        
                        <div>
                            <x-input-label for="title" :value="__('Titolo')" class="text-[10px] uppercase font-bold text-gray-500" />
                            <x-text-input id="title" name="title" type="text" :value="old('title', $track->title)" class="mt-1 block w-full text-sm border-gray-200 focus:border-black focus:ring-0" required />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="genre" :value="__('Genere')" class="text-[10px] uppercase font-bold text-gray-500" />
                                <select id="genre" name="genre" required class="mt-1 block w-full border-gray-200 rounded-lg text-sm focus:border-black focus:ring-0">
                                    <option value="">Seleziona Genere</option>
                                    @foreach(config('music.genres') as $value => $label)
                                        <option value="{{ $value }}" {{ (isset($track) && $track->genre == $value) ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <x-input-label for="version" :value="__('Versione')" class="text-[10px] uppercase font-bold text-gray-500" />
                                <x-text-input id="version" name="version" type="text" :value="old('version', $track->version)" class="mt-1 block w-full text-sm border-gray-200 focus:border-black focus:ring-0" />
                            </div>
                        </div>

                        <div class="w-full md:w-1/3">
                            <x-input-label for="bpm" :value="__('BPM')" class="text-[10px] uppercase font-bold text-gray-500" />
                            <x-text-input id="bpm" name="bpm" type="number" :value="old('bpm', $track->bpm)" class="mt-1 block w-full text-sm text-center border-gray-200 focus:border-black focus:ring-0" />
                        </div>
                    </div>

                    <!-- 2. INFO SISTEMA (Read Only) -->
                    <div class="p-6 bg-gray-50 rounded-xl border border-gray-100 flex items-center justify-between">
                        <div class="space-y-1">
                            <span class="block text-[8px] font-black uppercase text-gray-400 tracking-widest">Stato Approvazione</span>
                            <span class="text-[10px] font-bold uppercase {{ $track->is_approved ? 'text-green-500' : 'text-orange-400' }}">
                                {{ $track->is_approved ? 'Approved & Live' : 'Pending Review' }}
                            </span>
                        </div>
                        <div class="text-right">
                            <span class="block text-[8px] font-black uppercase text-gray-400 tracking-widest">Slug Sistema</span>
                            <span class="text-[10px] font-mono text-gray-400">{{ $track->slug }}</span>
                        </div>
                    </div>

                    <!-- 3. PROMOZIONE & CONDIVISIONE (Aggiunto qui) -->
                    <div class="p-8 bg-gray-50 rounded-xl border border-gray-100">
                        <h2 class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-400 mb-6 italic">Promozione & QR Link</h2>
                        
                        <div class="flex flex-col md:flex-row items-center gap-10">
                            <!-- QR Preview -->
                            <div class="bg-white p-3 rounded-2xl border border-gray-200 shadow-sm flex flex-col items-center gap-2 group">
                                <img src="{{ asset('storage/' . $track->qr_code_path) }}" class="w-32 h-32" alt="QR Code">
                                <a href="{{ asset('storage/' . $track->qr_code_path) }}" download class="text-[8px] font-black uppercase tracking-widest text-gray-300 group-hover:text-black transition-colors">Download SVG</a>
                            </div>

                            <!-- Bottoni Social -->
                            <div class="flex-1 space-y-5">
                                <div class="space-y-2">
                                    <span class="text-[9px] font-black uppercase tracking-widest text-gray-400">Share on channels:</span>
                                    <div class="flex flex-wrap gap-3">
                                        <!-- WhatsApp -->
                                        <a href="https://wa.me{{ urlencode('Check out my track on Rude-Hz: ' . url('/track/'.$track->slug)) }}" target="_blank" 
                                           class="bg-[#25D366] text-white px-5 py-3 rounded-xl text-[9px] font-black uppercase tracking-widest hover:shadow-lg transition-all transform hover:-translate-y-1">
                                           WhatsApp
                                        </a>
                                        
                                        <!-- Facebook -->
                                        <a href="https://facebook.com{{ urlencode(url('/track/'.$track->slug)) }}" target="_blank" 
                                           class="bg-[#1877F2] text-white px-5 py-3 rounded-xl text-[9px] font-black uppercase tracking-widest hover:shadow-lg transition-all transform hover:-translate-y-1">
                                           Facebook
                                        </a>

                                        <!-- Instagram (Artist Profile) -->
                                        @if(auth()->user()->artist->instagram_url)
                                            <a href="{{ auth()->user()->artist->instagram_url }}" target="_blank" 
                                               class="bg-gradient-to-tr from-[#f9ce34] via-[#ee2a7b] to-[#6228d7] text-white px-5 py-3 rounded-xl text-[9px] font-black uppercase tracking-widest hover:shadow-lg transition-all transform hover:-translate-y-1">
                                               Instagram
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                <div class="pt-4 border-t border-gray-200">
                                    <span class="text-[8px] font-black uppercase tracking-widest text-gray-300 block mb-1">Direct Link:</span>
                                    <span class="text-[10px] font-mono text-indigo-500 break-all bg-white px-2 py-1 rounded border border-gray-100">{{ url('/track/'.$track->slug) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- AZIONE FINALE -->
                    <div class="pt-6 border-t border-gray-100 flex justify-end items-center gap-6">
                        <button type="submit" class="w-full md:w-auto bg-black hover:bg-gray-800 text-white text-[11px] font-black tracking-[0.3em] uppercase px-12 py-5 rounded-xl shadow-xl transition-all transform hover:-translate-y-1">
                            {{ __('Salva modifiche') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

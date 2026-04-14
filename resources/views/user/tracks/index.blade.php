<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight uppercase tracking-widest">
            {{ __('Tracce') }}
        </h2>
    </x-slot>

    <!-- activeAccordion: 1 apre il Catalogo all'avvio -->
    <div class="py-12 bg-gray-100 min-h-screen" x-data="{ activeAccordion: 1 }">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">
            
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-500 text-white text-[10px] font-black uppercase rounded-lg shadow-lg tracking-[0.2em]">
                    {{ session('success') }}
                </div>
            @endif

            <!-- SEZIONE 1: IL MIO CATALOGO -->
            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                <button @click="activeAccordion = (activeAccordion === 1 ? 0 : 1)" 
                        class="w-full px-8 py-5 flex justify-between items-center bg-white hover:bg-gray-50 transition-all focus:outline-none">
                    <span class="text-[11px] font-black uppercase tracking-[0.3em] text-gray-800 italic">1. IL MIO CATALOGO ({{ $tracks->count() }})</span>
                    <svg class="h-4 w-4 transform transition-transform duration-300" :class="activeAccordion === 1 ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="activeAccordion === 1" x-collapse x-cloak class="border-t border-gray-50">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <tbody class="divide-y divide-gray-50">
                                @forelse($tracks as $track)
                                <tr class="hover:bg-gray-50/30 transition-all group">
                                    <!-- INFO TRACCIA -->
                                    <td class="px-8 py-6">
                                        <div class="flex flex-col">
                                            <span class="text-[11px] font-black text-gray-900 uppercase tracking-tighter">{{ $track->title }}</span>
                                            <span class="text-[9px] text-gray-400 font-bold uppercase tracking-widest">
                                                {{ $track->version ?? 'Original Mix' }} — {{ $track->genre }}
                                            </span>
                                        </div>
                                    </td>

                                    <!-- PLAYER -->
                                    <td class="px-4 py-6 text-center">
                                        <div class="bg-white border border-gray-100 rounded-full px-4 py-1 shadow-sm inline-block">
                                            <audio controls class="h-6 w-44 grayscale opacity-60">
                                                <source src="{{ asset('storage/' . $track->file_path) }}" type="audio/mpeg">
                                            </audio>
                                        </div>
                                    </td>

                                    <!-- AZIONI -->
                                    <td class="px-8 py-6 text-right">
                                        <div class="flex justify-end items-center gap-6">
                                            
                                            <!-- ICONA QR FISSA (Solo visuale, scura, niente link) -->
                                            <div class="text-gray-900 opacity-100" title="QR Code generato">
                                                <svg xmlns="http://w3.org" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                                </svg>
                                            </div>

                                            <!-- EDIT -->
                                            <a href="{{ route('user.track.edit', $track->id) }}" class="text-indigo-400 hover:text-indigo-600 transition-colors transform hover:scale-110" title="Modifica">
                                                <svg xmlns="http://w3.org" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            
                                            <!-- DELETE -->
                                            <form action="{{ route('user.track.destroy', $track->id) }}" method="POST" onsubmit="return confirm('Sicuro di voler eliminare?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-300 hover:text-red-500 transition-colors transform hover:scale-110">
                                                    <svg xmlns="http://w3.org" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-8 py-12 text-center text-[10px] font-black text-gray-300 uppercase tracking-[0.3em] italic">Il catalogo è vuoto</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- SEZIONE 2: CARICA NUOVA TRACCIA -->
            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                <button @click="activeAccordion = (activeAccordion === 2 ? 0 : 2)" 
                        class="w-full px-8 py-5 flex justify-between items-center bg-white hover:bg-gray-50 transition-all focus:outline-none">
                    <span class="text-[11px] font-black uppercase tracking-[0.3em] text-gray-800 italic">2. CARICA NUOVA TRACCIA</span>
                    <svg class="h-4 w-4 transform transition-transform duration-300" :class="activeAccordion === 2 ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="activeAccordion === 2" x-collapse x-cloak class="p-8 border-t border-gray-50 space-y-6">
                    <form action="{{ route('track.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-6">
                            <div>
                                <x-input-label for="title" :value="__('Titolo')" class="text-[10px] uppercase text-gray-400 font-bold" />
                                <x-text-input id="title" name="title" required class="mt-1 block w-full text-sm border-gray-200 focus:border-black focus:ring-0" placeholder="Nome traccia..." />
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <x-input-label for="genre" :value="__('Genere')" class="text-[10px] uppercase text-gray-400 font-bold" />
                                    <select id="genre" name="genre" required class="mt-1 block w-full border-gray-200 rounded-lg text-sm focus:border-black focus:ring-0">
                                        @foreach(config('music.genres') as $value => $label)
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <x-input-label for="version" :value="__('Versione')" class="text-[10px] uppercase text-gray-400 font-bold" />
                                    <x-text-input id="version" name="version" class="mt-1 block w-full text-sm border-gray-200 focus:border-black focus:ring-0" placeholder="Original Mix..." />
                                </div>
                                <div>
                                    <x-input-label for="bpm" :value="__('BPM')" class="text-[10px] uppercase text-gray-400 font-bold" />
                                    <x-text-input id="bpm" name="bpm" type="number" class="mt-1 block w-full text-sm text-center border-gray-200 focus:border-black focus:ring-0" placeholder="140" />
                                </div>
                            </div>

                            <div class="p-8 bg-gray-50 border-2 border-dashed border-gray-100 rounded-xl text-center">
                                <x-input-label for="audio_file" :value="__('File Audio')" class="text-[10px] uppercase text-gray-500 font-bold mb-3 block" />
                                <input type="file" id="audio_file" name="audio_file" required class="block w-full text-xs text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:bg-black file:text-white hover:file:bg-gray-800 cursor-pointer">
                            </div>

                            <button type="submit" class="w-full bg-black text-white text-[11px] font-black tracking-[0.4em] uppercase py-5 rounded-xl shadow-xl hover:shadow-2xl transition-all transform hover:-translate-y-1">
                                {{ __('Inizia Caricamento') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

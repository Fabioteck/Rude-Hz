<x-studio-layout>
    <div class="py-12 bg-[#0a0a0a] min-h-screen" x-data="{ activeAccordion: 1, deleteModal: null }">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">
            
            @if(session('success'))
                <div class="mb-4 p-4 bg-[#d9ff00] text-black text-[10px] font-black uppercase rounded-lg shadow-lg tracking-[0.2em]">
                    {{ session('success') }}
                </div>
            @endif

            <!-- SEZIONE 1: IL MIO CATALOGO -->
            <div class="bg-[#111] border border-gray-800 rounded-xl overflow-hidden shadow-sm">
                <button @click="activeAccordion = (activeAccordion === 1 ? 0 : 1)" 
                        class="w-full px-8 py-5 flex justify-between items-center bg-[#111] hover:bg-[#1a1a1a] transition-all focus:outline-none">
                    <span class="text-[11px] font-black uppercase tracking-[0.3em] text-[#d9ff00] italic">1. IL MIO CATALOGO ({{ $tracks->count() }})</span>
                    <svg class="h-4 w-4 text-gray-500 transform transition-transform duration-300" :class="activeAccordion === 1 ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="activeAccordion === 1" x-collapse x-cloak class="border-t border-gray-800">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <tbody class="divide-y divide-gray-800">
                                @forelse($tracks as $track)
                                <tr class="hover:bg-[#1a1a1a] transition-all group">
                                    <td class="px-8 py-6">
                                        <div class="flex flex-col">
                                            <span class="text-[12px] font-black text-white uppercase tracking-tighter">{{ $track->title }}</span>
                                            <span class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mt-1">
                                                {{ $track->version ?? 'Original Mix' }} — {{ $track->genre }}
                                            </span>
                                        </div>
                                    </td>

                                    <td class="px-4 py-6 text-center">
                                        <div class="bg-black border border-gray-800 rounded-lg px-4 py-2 shadow-sm inline-flex items-center gap-2">
                                            <svg class="h-4 w-4 text-[#d9ff00]" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"/></svg>
                                            <audio controls class="h-6 w-32 grayscale opacity-80">
                                                <source src="{{ asset('storage/' . $track->file_path) }}" type="audio/mpeg">
                                            </audio>
                                        </div>
                                    </td>

                                    <td class="px-8 py-6 text-right">
                                        <div class="flex justify-end items-center gap-4">
                                            <a href="{{ route('user.track.edit', $track->id) }}" class="p-2 bg-[#1a1a1a] text-gray-400 hover:text-white rounded-lg transition-colors" title="Modifica">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                            </a>
                                            
                                            <button @click="deleteModal = {{ $track->id }}" class="p-2 bg-[#1a1a1a] text-red-900 hover:text-red-500 rounded-lg transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-8 py-12 text-center text-[10px] font-black text-gray-600 uppercase tracking-[0.3em] italic">Il catalogo è vuoto</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- MODAL CANCELLAZIONE -->
            <div x-show="deleteModal !== null" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-80" x-cloak>
                <div @click.away="deleteModal = null" class="bg-[#111] border border-gray-800 p-8 rounded-xl max-w-sm w-full text-center">
                    <h3 class="text-white font-black uppercase tracking-widest mb-4">Elimina Traccia</h3>
                    <p class="text-gray-500 text-[11px] mb-8">Sei sicuro di voler eliminare questa traccia? L'azione è irreversibile.</p>
                    <div class="flex gap-4">
                        <button @click="deleteModal = null" class="flex-1 py-3 bg-[#1a1a1a] text-white rounded-lg text-[10px] font-bold uppercase tracking-widest">Annulla</button>
                        <form x-bind:action="`{{ url('/user/tracks') }}/${deleteModal}`" method="POST" class="flex-1">
                            @csrf @method('DELETE')
                            <button type="submit" class="w-full py-3 bg-red-900 hover:bg-red-700 text-white rounded-lg text-[10px] font-bold uppercase tracking-widest">Elimina</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- SEZIONE 2: CARICA NUOVA TRACCIA -->
            <div class="bg-[#111] border border-gray-800 rounded-xl overflow-hidden shadow-sm">
                <button @click="activeAccordion = (activeAccordion === 2 ? 0 : 2)" 
                        class="w-full px-8 py-5 flex justify-between items-center bg-[#111] hover:bg-[#1a1a1a] transition-all focus:outline-none">
                    <span class="text-[11px] font-black uppercase tracking-[0.3em] text-[#d9ff00] italic">2. CARICA NUOVA TRACCIA</span>
                    <svg class="h-4 w-4 text-gray-500 transform transition-transform duration-300" :class="activeAccordion === 2 ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="activeAccordion === 2" x-collapse x-cloak class="p-8 border-t border-gray-800 space-y-6">
                    <form action="{{ route('track.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-6">
                            <div>
                                <label for="title" class="text-[10px] uppercase text-gray-500 font-bold">Titolo</label>
                                <input id="title" name="title" required class="mt-1 block w-full text-sm border-gray-800 bg-black text-white rounded-lg focus:border-[#d9ff00] focus:ring-0" placeholder="Nome traccia..." />
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="genre" class="text-[10px] uppercase text-gray-500 font-bold">Genere</label>
                                    <select id="genre" name="genre" required class="mt-1 block w-full border-gray-800 bg-black text-white rounded-lg text-sm focus:border-[#d9ff00] focus:ring-0">
                                        @foreach(config('music.genres', ['Techno' => 'Techno', 'House' => 'House']) as $value => $label)
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="version" class="text-[10px] uppercase text-gray-500 font-bold">Versione</label>
                                    <input id="version" name="version" class="mt-1 block w-full text-sm border-gray-800 bg-black text-white rounded-lg focus:border-[#d9ff00] focus:ring-0" placeholder="Original Mix..." />
                                </div>
                                <div>
                                    <label for="bpm" class="text-[10px] uppercase text-gray-500 font-bold">BPM</label>
                                    <input id="bpm" name="bpm" type="number" class="mt-1 block w-full text-sm border-gray-800 bg-black text-white rounded-lg text-center focus:border-[#d9ff00] focus:ring-0" placeholder="140" />
                                </div>
                            </div>

                            <div class="p-8 bg-black border-2 border-dashed border-gray-800 rounded-xl text-center">
                                <label for="audio_file" class="text-[10px] uppercase text-gray-500 font-bold mb-3 block">File Audio (MP3/WAV, Max 15MB)</label>
                                <input type="file" id="audio_file" name="audio_file" required class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:bg-[#d9ff00] file:text-black hover:file:bg-white cursor-pointer">
                            </div>

                            <button type="submit" class="w-full bg-[#d9ff00] hover:bg-white text-black text-[11px] font-black tracking-[0.4em] uppercase py-5 rounded-xl shadow-xl transition-all transform hover:-translate-y-1">
                                {{ __('Inizia Caricamento') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-studio-layout>

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-2xl text-gray-900 leading-tight uppercase tracking-tighter">
                {{ __('Anagrafica Artisti Rude-Hz') }}
            </h2>
            <a href="{{ route('admin.artists.create') }}" class="bg-black hover:bg-gray-800 text-[#d9ff00] text-xs font-black py-3 px-6 rounded-xl transition uppercase tracking-widest shadow-lg">
                + Nuovo Artista
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Messaggi di Feedback --}}
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 font-bold rounded shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-3xl border border-gray-100">
                <div class="p-0"> {{-- Rimosso padding interno per far toccare la tabella ai bordi --}}
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50">
                                <th class="p-6 border-b text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Artista</th>
                                <th class="p-6 border-b text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Social Connect</th>
                                <th class="p-6 border-b text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Tech Stack (Nostr/LN)</th>
                                <th class="p-6 border-b text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] text-right">Console</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($artists as $artist)
                                <tr class="hover:bg-indigo-50/30 transition-colors group">
                                    <td class="p-6">
                                        <div class="flex items-center">
                                            {{-- Avatar Artista --}}
                                            @if($artist->profile_image)
                                                <img src="{{ asset('storage/' . $artist->profile_image) }}" class="w-12 h-12 rounded-xl object-cover mr-4 shadow-md border-2 border-white group-hover:border-indigo-200 transition-all">
                                            @else
                                                <div class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center mr-4 text-gray-400 text-[10px] font-black border-2 border-dashed">R-HZ</div>
                                            @endif
                                            
                                            <div>
                                                <a href="{{ route('admin.artists.edit', $artist->id) }}" class="font-black text-gray-900 hover:text-indigo-600 transition uppercase tracking-tight text-lg">
                                                    {{ $artist->name }}
                                                </a>
                                                <div class="text-[10px] text-indigo-500 uppercase font-black tracking-widest mt-0.5">
                                                    {{ $artist->style ?? 'NO STYLE SET' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="p-6">
                                        <div class="flex gap-3 grayscale opacity-40 group-hover:grayscale-0 group-hover:opacity-100 transition-all">
                                            @if($artist->soundcloud_url)<span class="text-xl" title="SoundCloud">☁️</span>@endif
                                            @if($artist->instagram_url)<span class="text-xl" title="Instagram">📸</span>@endif
                                            @if($artist->spotify_url)<span class="text-xl" title="Spotify">🎧</span>@endif
                                            @if($artist->youtube_url)<span class="text-xl" title="YouTube">📺</span>@endif
                                        </div>
                                    </td>

                                    <td class="p-6">
                                        @if($artist->nostr_npub)
                                            <div class="flex items-center text-purple-600 font-mono text-[10px] mb-1.5 font-bold" title="Nostr Key">
                                                <span class="bg-purple-100 px-1.5 py-0.5 rounded mr-2">N</span> {{ Str::limit($artist->nostr_npub, 16) }}
                                            </div>
                                        @endif
                                        @if($artist->ln_address)
                                            <div class="flex items-center text-orange-500 font-mono text-[10px] font-bold" title="Lightning Address">
                                                <span class="bg-orange-100 px-1.5 py-0.5 rounded mr-2">⚡</span> {{ $artist->ln_address }}
                                            </div>
                                        @else
                                            <span class="text-gray-300 text-[10px] font-bold uppercase tracking-widest italic">Tips Offline</span>
                                        @endif
                                    </td>
                                    
                                    <td class="p-6 text-right">
                                        <div class="flex justify-end items-center gap-3">
                                            {{-- Bottone Edit --}}
                                            <a href="{{ route('admin.artists.edit', $artist->id) }}" 
                                               class="bg-white border-2 border-gray-200 hover:border-black text-black px-4 py-2 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all">
                                                Edit ✏️
                                            </a>

                                            {{-- Form Delete --}}
                                            <form action="{{ route('admin.artists.destroy', $artist->id) }}" method="POST" 
                                                  onsubmit="return confirm('⚠️ ATTENZIONE: Vuoi davvero eliminare {{ $artist->name }}?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-50 text-red-600 hover:bg-red-600 hover:text-white px-4 py-2 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all">
                                                    Del 🗑️
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-20 text-center">
                                        <p class="text-gray-400 font-black uppercase tracking-[0.3em] text-sm italic">// Database Artisti Vuoto //</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- Paginazione --}}
                    @if($artists->hasPages())
                        <div class="p-6 bg-gray-50 border-t border-gray-100">
                            {{ $artists->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

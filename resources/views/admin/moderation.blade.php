<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-3xl text-[#d9ff00] leading-tight uppercase tracking-tighter italic">
            {{ __('Moderazione Master - Rude-Hz') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#0a0a0a] min-h-screen text-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- MESSAGGI DI STATO -->
            @if(session('success'))
                <div class="mb-8 p-4 bg-[#d9ff00]/10 border border-[#d9ff00] text-[#d9ff00] rounded-2xl font-black text-center uppercase tracking-[0.3em] text-xs shadow-lg shadow-[#d9ff00]/5">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-[#111111] rounded-[2.5rem] border border-white/5 overflow-hidden shadow-2xl">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[10px] uppercase tracking-[0.2em] text-gray-500 border-b border-white/5 bg-black/20 font-mono">
                            <th class="p-6 text-center">Ascolta</th>
                            <th class="p-6">Traccia / Versione</th>
                            <th class="p-6">Artista</th>
                            <th class="p-6">Tech Info</th>
                            <th class="p-6 text-right">Azioni</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($pendingTracks as $track)
                            <tr class="hover:bg-white/[0.02] transition group">
                                <!-- PLAYER RAPIDO ADMIN -->
                                <td class="p-6 text-center">
                                    <audio id="audio-{{ $track->id }}" src="{{ Storage::url($track->file_path) }}"></audio>
                                    <button onclick="document.getElementById('audio-{{ $track->id }}').paused ? document.getElementById('audio-{{ $track->id }}').play() : document.getElementById('audio-{{ $track->id }}').pause()" 
                                            class="w-12 h-12 rounded-full bg-white/5 text-white flex items-center justify-center hover:bg-[#d9ff00] hover:text-black transition shadow-xl">
                                        <svg class="w-5 h-5 ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"></path></svg>
                                    </button>
                                </td>

                                <td class="p-6">
                                    <p class="font-black text-xl text-white uppercase italic tracking-tighter">{{ $track->title }}</p>
                                    <p class="text-[10px] text-[#d9ff00] font-mono italic uppercase tracking-widest">{{ $track->version }}</p>
                                </td>

                                <td class="p-6">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $track->artist && $track->artist->profile_image ? Storage::url($track->artist->profile_image) : 'https://picsum.photos' }}" class="w-8 h-8 rounded-full object-cover grayscale">
                                        <span class="font-bold text-gray-400 italic uppercase tracking-tight">{{ $track->artist->name ?? 'Unknown' }}</span>
                                    </div>
                                </td>

                                <td class="p-6 font-mono text-[10px] text-zinc-500 uppercase">
                                    {{ $track->bpm }} BPM <br> {{ $track->genre }}
                                </td>

                                <td class="p-6 text-right space-y-2 md:space-y-0 md:space-x-2">
                                    <!-- FORM APPROVAZIONE (Verde) -->
                                    <form action="{{ route('admin.track.approve', $track) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="bg-[#d9ff00] hover:bg-white text-black font-black uppercase px-5 py-3 rounded-full text-[10px] tracking-widest transition shadow-lg shadow-[#d9ff00]/10">
                                            APPROVA
                                        </button>
                                    </form>

                                    <!-- FORM ELIMINAZIONE (Rosso) -->
                                    <form action="{{ route('admin.track.destroy', $track) }}" method="POST" class="inline" onsubmit="return confirm('⚠️ SEI SICURO? Il file MP3 e il QR Code verranno cancellati dal Raspberry!');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600 hover:bg-white text-white hover:text-red-600 font-black uppercase px-5 py-3 rounded-full text-[10px] tracking-widest transition shadow-lg">
                                            ELIMINA
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-32 text-center">
                                    <span class="text-6xl block mb-6 grayscale opacity-20">🛡️</span>
                                    <p class="text-zinc-600 uppercase font-mono tracking-[0.3em] text-xs italic font-bold">Nessun master in attesa. <br> Il Raspberry sta riposando.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

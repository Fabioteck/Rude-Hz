<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-3xl text-[#d9ff00] leading-tight uppercase tracking-tighter italic">
                {{ __('Master Online (Live)') }}
            </h2>
            <a href="{{ route('admin.moderation') }}" class="text-xs font-bold uppercase text-gray-500 hover:text-white transition">
                ← Torna alla Moderazione
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-[#0a0a0a] min-h-screen text-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-[#111111] rounded-[2.5rem] border border-white/5 overflow-hidden shadow-2xl">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[10px] uppercase tracking-[0.2em] text-gray-500 border-b border-white/5 bg-black/20 font-mono">
                            <th class="p-6">Stato</th>
                            <th class="p-6">Traccia / Artista</th>
                            <th class="p-6">ISRC / BPM</th>
                            <th class="p-6">QR</th>
                            <th class="p-6 text-right">Azione Fatale</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($approvedTracks as $track)
                            <tr class="hover:bg-red-500/[0.02] transition group">
                                <td class="p-6">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-black bg-[#d9ff00]/10 text-[#d9ff00] uppercase tracking-widest">
                                        LIVE
                                    </span>
                                </td>
                                <td class="p-6">
                                    <p class="font-black text-xl text-white uppercase italic tracking-tighter leading-none">{{ $track->title }}</p>
                                    <p class="text-xs text-gray-500 font-bold italic">{{ $track->artist->name ?? 'Unknown' }}</p>
                                </td>
                                <td class="p-6 font-mono text-[10px] text-zinc-500 uppercase leading-relaxed">
                                    {{ $track->isrc_code ?? 'NO-ISRC' }} <br> {{ $track->bpm ?? '140' }} BPM
                                </td>
                                <td class="p-6">
                                    @if($track->qr_code_path)
                                        <img src="{{ Storage::url($track->qr_code_path) }}" class="w-8 h-8 bg-white p-1 rounded-md opacity-50 group-hover:opacity-100 transition">
                                    @endif
                                </td>
                                <td class="p-6 text-right">
                                    <!-- FORM ELIMINAZIONE TOTALE -->
                                    <form action="{{ route('admin.track.destroy', $track) }}" method="POST" onsubmit="return confirm('⚠️ ATTENZIONE: Questa traccia è LIVE. Se confermi, sparirà dalla radio e dalla Home. Procedo?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-transparent border border-red-900/50 hover:bg-red-600 text-red-600 hover:text-white font-black uppercase px-6 py-3 rounded-full text-[10px] tracking-widest transition-all duration-300">
                                            ELIMINA DEFINITIVAMENTE
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-32 text-center">
                                    <p class="text-zinc-600 uppercase font-mono tracking-[0.3em] text-xs italic font-bold">Nessun master online al momento.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-3xl text-[#d9ff00] leading-tight uppercase tracking-tighter italic">
            {{ __('Gestione Crew Artisti') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#0a0a0a] min-h-screen text-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#111111] rounded-[2.5rem] border border-white/5 overflow-hidden shadow-2xl">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[10px] uppercase tracking-[0.2em] text-gray-500 border-b border-white/5 bg-black/20 font-mono">
                            <th class="p-6">Artista</th>
                            <th class="p-6">Social / Web3</th>
                            <th class="p-6 text-center">Tracce</th>
                            <th class="p-6 text-right">Azioni</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($allArtists as $artist)
                            <tr class="hover:bg-white/[0.02] transition">
                                <td class="p-6 flex items-center gap-4">
                                    <img src="{{ $artist->profile_image ? Storage::url($artist->profile_image) : 'https://picsum.photos' }}" class="w-12 h-12 rounded-full border border-white/10 object-cover">
                                    <div>
                                        <p class="font-black text-white uppercase italic tracking-tighter">{{ $artist->name }}</p>
                                        <p class="text-[10px] text-zinc-500 font-mono italic">{{ $artist->style }}</p>
                                    </div>
                                </td>
                                <td class="p-6 space-x-2">
                                    @if($artist->instagram_url) <span class="text-xs opacity-50">IG</span> @endif
                                    @if($artist->ln_address) <span class="text-xs text-[#d9ff00]">⚡ LN</span> @endif
                                    @if($artist->nostr_npub) <span class="text-xs text-purple-500">N</span> @endif
                                </td>
                                <td class="p-6 text-center font-black text-[#d9ff00]">
                                    {{ $artist->tracks_count }}
                                </td>
                                <td class="p-6 text-right">
                                    <button class="text-gray-500 hover:text-white mr-4 uppercase text-[10px] font-black tracking-widest transition">Edit</button>
                                    <form action="#" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button class="text-red-600 hover:text-white uppercase text-[10px] font-black tracking-widest transition">Ban</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

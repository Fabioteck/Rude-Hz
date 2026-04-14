<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight uppercase font-black italic">
                {{ __('Modifica Artista: ') }} {{ $artist->name }}
            </h2>
            <a href="{{ route('admin.artists.index') }}" class="text-xs font-bold text-gray-500 hover:text-indigo-600 transition uppercase">
                &larr; Torna alla lista
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('admin.artists.update', $artist) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- INFO BASE -->
                <div class="bg-white p-6 shadow sm:rounded-lg border-b-4 border-indigo-600">
                    <h3 class="text-lg font-bold mb-4 uppercase italic tracking-tighter">Identità Artistica</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="name" :value="__('Nome Artista')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full font-bold" :value="old('name', $artist->name)" required />
                        </div>
                        <div>
                            <x-input-label for="genre" :value="__('Genere')" />
                            <x-text-input id="genre" name="genre" type="text" class="mt-1 block w-full" :value="old('genre', $artist->genre)" />
                        </div>
                        <div class="md:col-span-2">
                            <x-input-label for="bio" :value="__('Biografia')" />
                            <textarea name="bio" rows="4" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">{{ old('bio', $artist->bio) }}</textarea>
                        </div>
                        <div class="md:col-span-2 flex items-center gap-6">
                            @if($artist->profile_image)
                                <img src="{{ asset('storage/' . $artist->profile_image) }}" class="w-20 h-20 rounded-full object-cover border-2 border-indigo-100">
                            @endif
                            <div class="flex-1">
                                <x-input-label for="profile_image" :value="__('Aggiorna Foto Profilo')" />
                                <input type="file" name="profile_image" class="mt-1 block w-full text-sm text-gray-500" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PROTOCOLLI SATOSHI & NOSTR -->
                <div class="bg-orange-50 p-6 shadow sm:rounded-lg border-b-4 border-orange-400">
                    <h3 class="text-lg font-bold mb-4 uppercase italic tracking-tighter text-orange-800 flex items-center">
                        <span class="mr-2">⚡</span> Protocolli & Mance
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="ln_address" :value="__('Lightning Address (LNURL)')" />
                            <x-text-input id="ln_address" name="ln_address" type="text" class="mt-1 block w-full border-orange-200 font-mono text-xs" :value="old('ln_address', $artist->ln_address)" placeholder="utente@getalby.com" />
                        </div>
                        <div>
                            <x-input-label for="nostr_npub" :value="__('Nostr Public Key (npub)')" />
                            <x-text-input id="nostr_npub" name="nostr_npub" type="text" class="mt-1 block w-full border-purple-200 font-mono text-xs" :value="old('nostr_npub', $artist->nostr_npub)" placeholder="npub1..." />
                        </div>
                    </div>
                </div>

                <!-- SOCIAL LINKS -->
                <div class="bg-white p-6 shadow sm:rounded-lg border-b-4 border-gray-200">
                    <h3 class="text-lg font-bold mb-4 uppercase italic tracking-tighter">Social & Web</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach(['soundcloud', 'spotify', 'instagram', 'facebook', 'youtube'] as $social)
                            @php $field = $social . '_url'; @endphp
                            <div>
                                <x-input-label for="{{ $field }}" :value="__(ucfirst($social))" />
                                <x-text-input id="{{ $field }}" name="{{ $field }}" type="url" class="mt-1 block w-full text-xs" :value="old($field, $artist->$field)" />
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- BOTTONI AZIONE -->
                <div class="flex justify-end gap-4">
                    <x-secondary-button onclick="window.location='{{ route('admin.artists.index') }}'">
                        {{ __('Annulla') }}
                    </x-secondary-button>
                    <x-primary-button class="bg-indigo-600 hover:bg-black px-10 py-3">
                        {{ __('Salva Modifiche') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

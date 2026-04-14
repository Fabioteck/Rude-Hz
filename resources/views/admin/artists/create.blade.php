<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nuovo Artista Rude-Hz') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('admin.artists.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- SEZIONE 1: IDENTITA' -->
                <div class="bg-white p-6 rounded-lg shadow-sm border">
                    <h3 class="text-lg font-bold mb-4 border-b pb-2 text-indigo-600">Identità Artistica</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700">Nome Artista *</label>
                            <input type="text" name="name" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700">Genere Musicale</label>
                            <input type="text" name="genre" placeholder="es. Techno, Experimental..." class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700">Biografia</label>
                            <textarea name="bio" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700">Foto Artista</label>
                            <input type="file" name="photo" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        </div>
                    </div>
                </div>

                <!-- SEZIONE 2: WEB & SOCIAL -->
                <div class="bg-white p-6 rounded-lg shadow-sm border">
                    <h3 class="text-lg font-bold mb-4 border-b pb-2 text-indigo-600">Presenza Web</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 italic">SoundCloud URL</label>
                            <input type="url" name="soundcloud_url" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 italic">Instagram URL</label>
                            <input type="url" name="instagram_url" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 italic">YouTube URL</label>
                            <input type="url" name="youtube_url" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 italic">Facebook URL</label>
                            <input type="url" name="facebook_url" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                    </div>
                </div>

                <!-- SEZIONE 3: SATOSHI & NOSTR (PROTOCOL) -->
                <div class="bg-white p-6 rounded-lg shadow-sm border-2 border-indigo-100">
                    <h3 class="text-lg font-bold mb-4 border-b pb-2 text-orange-500 flex items-center">
                        <span class="mr-2">⚡</span> Protocolli & Mance
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700">Nostr Public Key (npub...)</label>
                            <input type="text" name="npub" placeholder="npub1..." class="mt-1 block w-full border-gray-300 rounded-md shadow-sm font-mono text-xs">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700">Lightning Address (LNURL)</label>
                            <input type="text" name="lightning_address" placeholder="utente@getalby.com" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm font-mono text-xs text-orange-600">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <a href="{{ route('admin.artists.index') }}" class="px-6 py-2 border rounded-md text-gray-600 font-bold hover:bg-gray-50">Annulla</a>
                    <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-md font-black shadow-lg hover:bg-indigo-700 transition uppercase">
                        Salva Artista su Rude-Hz
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

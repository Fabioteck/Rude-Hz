<x-studio-layout>
    <div class="py-12 min-h-screen bg-[#0a0a0a]" x-data="{ openSection: null }">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 p-4 bg-[#d9ff00] text-black text-xs font-black uppercase rounded-lg shadow-lg">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('user.update.artist') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <!-- 1. IDENTITÀ -->
                <div class="p-8 bg-[#111] border border-gray-800 shadow-sm rounded-xl">
                    <h2 class="text-[10px] font-black mb-8 uppercase tracking-[0.3em] text-[#d9ff00] border-b border-gray-800 pb-2">Artist Identity</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <x-input-label for="name" :value="__('Nome d\'Arte')" class="text-[10px] uppercase text-gray-400 font-bold" />
                            <x-text-input id="name" name="name" type="text" :value="old('name', $artist->name)" class="mt-1 block w-full text-sm border-gray-700 bg-black text-white focus:border-[#d9ff00] focus:ring-0" required />
                        </div>
                        <div>
                            <x-input-label for="slug" :value="__('Artist Slug')" class="text-[10px] uppercase text-gray-400 font-bold" />
                            <x-text-input id="slug" name="slug" type="text" :value="old('slug', $artist->slug)" class="mt-1 block w-full text-sm border-gray-800 bg-gray-900 text-gray-500" readonly />
                        </div>
                    </div>
                </div>

                <!-- 2. ABOUT -->
                <div class="p-8 bg-[#111] border border-gray-800 shadow-sm rounded-xl">
                    <h2 class="text-[10px] font-black mb-6 uppercase tracking-[0.3em] text-[#d9ff00] border-b border-gray-800 pb-2">About</h2>
                    <x-input-label for="bio" :value="__('Biografia')" class="text-[10px] uppercase text-gray-400 font-bold" />
                    <textarea id="bio" name="bio" rows="4" class="mt-2 w-full border-gray-800 bg-black text-white rounded-lg text-sm focus:border-[#d9ff00] focus:ring-0" placeholder="Racconta la tua storia...">{{ old('bio', $artist->bio) }}</textarea>
                </div>

                <!-- 3. VISUAL BRANDING (Accordion) -->
                <div class="p-8 bg-[#111] border border-gray-800 shadow-sm rounded-xl">
                    <button type="button" @click="openSection = (openSection === 'visual' ? null : 'visual')" class="flex justify-between items-center w-full focus:outline-none">
                        <h2 class="text-[10px] font-black uppercase tracking-[0.3em] text-[#d9ff00]">Visual Branding</h2>
                        <span class="text-[#d9ff00]" x-text="openSection === 'visual' ? '▲' : '▼'">▼</span>
                    </button>
                    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-12" x-show="openSection === 'visual'" x-cloak>
                        <div class="space-y-4">
                            <x-input-label for="photo" :value="__('Cover Image')" class="text-[10px] uppercase text-gray-400 font-bold" />
                            <div class="relative w-full h-40 bg-black border-2 border-dashed border-gray-800 rounded-xl overflow-hidden flex items-center justify-center">
                                <img id="preview-photo" src="{{ $artist->photo ? asset('storage/' . $artist->photo) : '' }}" class="{{ $artist->photo ? '' : 'hidden' }} w-full h-full object-cover">
                                <div id="placeholder-photo" class="{{ $artist->photo ? 'hidden' : '' }} text-[9px] text-gray-600 uppercase font-black">No Cover</div>
                            </div>
                            <input type="file" id="photo" name="photo" onchange="previewImage(this, 'preview-photo', 'placeholder-photo')" class="block w-full text-[10px] text-gray-400">
                        </div>
                        <div class="space-y-4 flex flex-col items-center">
                            <x-input-label for="profile_image" :value="__('Avatar Image')" class="text-[10px] uppercase text-gray-400 font-bold w-full" />
                            <div class="relative w-40 h-40 bg-black border-2 border-dashed border-gray-800 rounded-full overflow-hidden flex items-center justify-center">
                                <img id="preview-avatar" src="{{ $artist->profile_image ? asset('storage/' . $artist->profile_image) : '' }}" class="{{ $artist->profile_image ? '' : 'hidden' }} w-full h-full object-cover">
                                <div id="placeholder-avatar" class="{{ $artist->profile_image ? 'hidden' : '' }} text-[9px] text-gray-600 uppercase font-black">No Avatar</div>
                            </div>
                            <input type="file" id="profile_image" name="profile_image" onchange="previewImage(this, 'preview-avatar', 'placeholder-avatar')" class="block w-full text-[10px] text-gray-400">
                        </div>
                    </div>
                </div>

                <!-- 4. PROTOCOLS & PAYMENTS (Accordion) -->
                <div class="p-8 bg-[#111] border border-gray-800 shadow-sm rounded-xl">
                    <button type="button" @click="openSection = (openSection === 'payments' ? null : 'payments')" class="flex justify-between items-center w-full focus:outline-none">
                        <h2 class="text-[10px] font-black uppercase tracking-[0.3em] text-[#d9ff00]">Protocols & Payments</h2>
                        <span class="text-[#d9ff00]" x-text="openSection === 'payments' ? '▲' : '▼'">▼</span>
                    </button>
                    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-8" x-show="openSection === 'payments'" x-cloak>
                        <div>
                            <x-input-label for="ln_address" :value="__('Lightning Address (Zaps)')" class="text-[10px] uppercase text-orange-500 font-bold" />
                            <x-text-input id="ln_address" name="ln_address" :value="old('ln_address', $artist->ln_address)" class="mt-1 block w-full text-sm border-gray-700 bg-black text-white focus:border-orange-500 focus:ring-0" placeholder="user@getalby.com" />
                        </div>
                        <div>
                            <x-input-label for="nostr_npub" :value="__('Nostr NPUB')" class="text-[10px] uppercase text-purple-500 font-bold" />
                            <x-text-input id="nostr_npub" name="nostr_npub" :value="old('nostr_npub', $artist->nostr_npub)" class="mt-1 block w-full text-sm border-gray-700 bg-black text-white focus:border-purple-500 focus:ring-0" placeholder="npub1..." />
                        </div>
                    </div>
                </div>

                <!-- 5. SOCIAL & STREAMING (Accordion) -->
                <div class="p-8 bg-[#111] border border-gray-800 shadow-sm rounded-xl">
                    <button type="button" @click="openSection = (openSection === 'social' ? null : 'social')" class="flex justify-between items-center w-full focus:outline-none">
                        <h2 class="text-[10px] font-black uppercase tracking-[0.3em] text-[#d9ff00]">Social & Streaming</h2>
                        <span class="text-[#d9ff00]" x-text="openSection === 'social' ? '▲' : '▼'">▼</span>
                    </button>
                    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6" x-show="openSection === 'social'" x-cloak>
                        <div>
                            <x-input-label for="spotify_url" :value="__('Spotify')" class="text-[9px] uppercase font-bold text-green-500" />
                            <x-text-input id="spotify_url" name="spotify_url" :value="old('spotify_url', $artist->spotify_url)" class="mt-1 block w-full text-xs bg-black border-gray-800 text-white" />
                        </div>
                        <div>
                            <x-input-label for="soundcloud_url" :value="__('Soundcloud')" class="text-[9px] uppercase font-bold text-orange-500" />
                            <x-text-input id="soundcloud_url" name="soundcloud_url" :value="old('soundcloud_url', $artist->soundcloud_url)" class="mt-1 block w-full text-xs bg-black border-gray-800 text-white" />
                        </div>
                        <div>
                            <x-input-label for="apple_music_url" :value="__('Apple Music')" class="text-[9px] uppercase font-bold text-red-400" />
                            <x-text-input id="apple_music_url" name="apple_music_url" :value="old('apple_music_url', $artist->apple_music_url)" class="mt-1 block w-full text-xs bg-black border-gray-800 text-white" />
                        </div>
                        <div>
                            <x-input-label for="youtube_url" :value="__('YouTube')" class="text-[9px] uppercase font-bold text-red-500" />
                            <x-text-input id="youtube_url" name="youtube_url" :value="old('youtube_url', $artist->youtube_url)" class="mt-1 block w-full text-xs bg-black border-gray-800 text-white" />
                        </div>
                        <div>
                            <x-input-label for="instagram_url" :value="__('Instagram')" class="text-[9px] uppercase font-bold text-pink-500" />
                            <x-text-input id="instagram_url" name="instagram_url" :value="old('instagram_url', $artist->instagram_url)" class="mt-1 block w-full text-xs bg-black border-gray-800 text-white" />
                        </div>
                        <div>
                            <x-input-label for="facebook_url" :value="__('Facebook')" class="text-[9px] uppercase font-bold text-blue-500" />
                            <x-text-input id="facebook_url" name="facebook_url" :value="old('facebook_url', $artist->facebook_url)" class="mt-1 block w-full text-xs bg-black border-gray-800 text-white" />
                        </div>
                    </div>
                </div>

                <!-- BOTTONE SALVATAGGIO -->
                <div class="flex justify-end pt-4">
                    <button type="submit" class="w-full md:w-1/3 bg-[#d9ff00] hover:bg-white text-black text-[11px] font-black tracking-[0.3em] uppercase px-8 py-5 rounded-xl transition-all shadow-xl hover:shadow-[#d9ff00]/20 transform hover:-translate-y-1">
                        {{ __('Update Studio') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewImage(input, previewId, placeholderId) {
            const preview = document.getElementById(previewId);
            const placeholder = document.getElementById(placeholderId);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    if (placeholder) placeholder.classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-studio-layout>

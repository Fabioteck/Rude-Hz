<x-app-layout>
    <!-- Header Artista (Cover + Avatar) -->
    <div class="relative h-[400px] bg-gray-900">
        @if($artist->photo)
            <img src="{{ asset('storage/' . $artist->photo) }}" class="w-full h-full object-cover opacity-60">
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-white via-transparent to-transparent"></div>
        
        <div class="absolute -bottom-16 left-1/2 -translate-x-1/2 text-center w-full">
            <div class="inline-block relative">
                <img src="{{ $artist->profile_image ? asset('storage/' . $artist->profile_image) : asset('images/default-avatar.png') }}" 
                     class="w-40 h-40 rounded-full border-8 border-white shadow-2xl object-cover bg-white">
                @if($artist->ln_address)
                    <div class="absolute bottom-2 right-2 bg-[#d9ff00] p-2 rounded-full shadow-lg border-2 border-white" title="Lightning Zaps Active">
                        <svg class="w-5 h-5 text-black" fill="currentColor" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z""")/>></svg>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="pt-24 pb-16 bg-white min-h-screen">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h1 class="text-4xl font-black text-gray-900 uppercase tracking-tighter">{{ $artist->name }}</h1>
            <p class="text-gray-400 text-[10px] uppercase tracking-[0.4em] mt-2">{{ $artist->style ?? 'Electronic Artist' }}</p>

            <!-- Social Links Icons -->
            <div class="flex justify-center gap-6 mt-8">
                @if($artist->spotify_url) <a href="{{ $artist->spotify_url }}" target="_blank" class="text-gray-400 hover:text-[#1DB954]">Spotify</a> @endif
                @if($artist->soundcloud_url) <a href="{{ $artist->soundcloud_url }}" target="_blank" class="text-gray-400 hover:text-[#FF3300]">SoundCloud</a> @endif
                @if($artist->instagram_url) <a href="{{ $artist->instagram_url }}" target="_blank" class="text-gray-400 hover:text-[#E4405F]">Instagram</a> @endif
                @if($artist->apple_music_url) <a href="{{ $artist->apple_music_url }}" target="_blank" class="text-gray-400 hover:text-[#FA243C]">Apple Music</a> @endif
            </div>

            <div class="mt-12 text-gray-600 leading-relaxed text-lg italic max-w-2xl mx-auto">
                {{ $artist->bio }}
            </div>

            <!-- Tracklist Approvata -->
            <div class="mt-20 text-left">
                <h3 class="text-[10px] font-black uppercase tracking-widest text-gray-400 border-b pb-2 mb-8">Approved Tracks</h3>
                <div class="space-y-4">
                    @foreach($tracks as $track)
                        <div class="p-4 bg-gray-50 rounded-lg flex items-center justify-between border border-gray-100">
                            <div>
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">{{ $track->genre }}</span>
                                <h4 class="font-bold text-gray-900">{{ $track->title }}</h4>
                            </div>
                            <audio controls class="h-8">
                                <source src="{{ asset('storage/' . $track->file_path) }}" type="audio/mpeg">
                            </audio>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

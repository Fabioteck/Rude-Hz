<x-admin-layout>
    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-normal text-gray-800">Selezione Playlist Raspberry</h2>
            <button form="playlist-form" class="bg-green-600 text-white px-5 py-2 rounded shadow-sm text-[11px] font-bold uppercase tracking-widest hover:bg-green-700 transition">
                AGGIORNA PLAYER
            </button>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-8">
            <form id="playlist-form" action="{{ route('admin.radio.playlist.update') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($approvedTracks as $track)
                        <label class="flex items-center justify-between p-4 border border-gray-100 rounded-lg hover:bg-gray-50 cursor-pointer transition">
                            <div class="flex items-center space-x-4">
                                <input type="checkbox" name="playlist[]" value="{{ $track->id }}" {{ $track->in_playlist ? 'checked' : '' }} class="rounded border-gray-300 text-black focus:ring-black">
                                <span class="text-sm font-bold text-gray-800">{{ $track->title }}</span>
                            </div>
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $track->artist->name ?? 'Indie' }}</span>
                        </label>
                    @endforeach
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>

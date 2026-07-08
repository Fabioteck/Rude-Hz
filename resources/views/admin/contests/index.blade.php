<x-admin-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Intestazione Pagina -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-black text-black uppercase tracking-tight italic">Gestione Contest Rude-Hz</h2>
            <a href="{{ route('admin.contests.create') }}" class="bg-black text-[#d9ff00] px-6 py-2 rounded-full text-[10px] font-black uppercase tracking-widest">+ Nuovo Contest</a>
        </div>

        <!-- Tabella Bianca Contest -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-12">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-50 uppercase text-[9px] font-black text-gray-300 tracking-[0.2em]">
                        <th class="px-8 py-5">Contest</th>
                        <th class="px-8 py-5 text-center">Iscritti</th>
                        <th class="px-8 py-5 text-center">Stato</th>
                        <th class="px-8 py-5 text-right">Console</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($contests as $contest)
                    <tr class="hover:bg-gray-50 transition">
                        <!-- Colonna Contest -->
                        <td class="px-8 py-4">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 rounded-lg bg-gray-100 overflow-hidden">
                                    <img src="{{ $contest->image_path ? asset('storage/'.$contest->image_path) : asset('images/default-contest.jpg') }}" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <div class="text-sm font-black text-black uppercase">{{ $contest->title }}</div>
                                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">{{ $contest->slug }}</div>
                                </div>
                            </div>
                        </td>

                        <!-- Iscritti -->
                        <td class="px-8 py-4 text-center">
                            <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-[10px] font-black uppercase">
                                {{ $contest->tracks_count }} Tracce
                            </span>
                        </td>

                        <!-- Stato -->
                        <td class="px-8 py-4 text-center">
                            @if($contest->is_active)
                                <span class="text-[9px] font-black px-3 py-1 rounded-full uppercase tracking-tighter bg-green-100 text-green-600">Attivo</span>
                            @else
                                <span class="text-[9px] font-black px-3 py-1 rounded-full uppercase tracking-tighter bg-red-100 text-red-600">Off</span>
                            @endif
                        </td>

                        <!-- Console Azioni -->
                        <td class="px-8 py-4 text-right">
                            <div class="flex justify-end items-center space-x-2">
                                <a href="{{ route('admin.contests.edit', $contest) }}" class="flex items-center text-[10px] font-black uppercase bg-orange-100 text-orange-600 px-3 py-1.5 rounded hover:bg-orange-200 transition-colors">
                                    Edit ✍️
                                </a>
                                <form action="{{ route('admin.contests.destroy', $contest) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="flex items-center text-[10px] font-black uppercase bg-red-100 text-red-600 px-3 py-1.5 rounded hover:bg-red-200 transition-colors">
                                        Del 🗑️
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-8 text-center text-gray-500 font-bold uppercase tracking-widest text-xs">
                            Nessun contest attivo.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Tracce in Revisione -->
        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden mb-12">
            <div class="px-8 py-6 border-b border-gray-50 bg-gray-50/30">
                <h3 class="text-sm font-black text-black uppercase tracking-widest">Tracce in Revisione per i Contest</h3>
            </div>
            
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-50 uppercase text-[9px] font-black text-gray-300 tracking-[0.2em]">
                        <th class="px-8 py-5">Cover</th>
                        <th class="px-8 py-5">Titolo / Artista</th>
                        <th class="px-8 py-5 text-center">Stato</th>
                        <th class="px-8 py-5 text-right">Console</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach(\App\Models\Track::where('is_approved', 0)->with('artist')->latest()->take(5)->get() as $track)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-8 py-4">
                            <div class="w-12 h-12 rounded-lg bg-gray-100 overflow-hidden">
                                <img src="{{ $track->cover_path ? asset('storage/'.$track->cover_path) : asset('images/default-track.jpg') }}" class="w-full h-full object-cover">
                            </div>
                        </td>
                        <td class="px-8 py-4">
                            <div class="text-sm font-black text-black uppercase">{{ $track->title }}</div>
                            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter mt-1">{{ $track->artist->name ?? 'Indipendente' }}</div>
                        </td>
                        <td class="px-8 py-4 text-center">
                            <span class="text-[9px] font-black px-3 py-1 rounded-full uppercase tracking-tighter bg-orange-100 text-orange-600">Pending</span>
                        </td>
                        <td class="px-8 py-4 text-right">
                            <div class="flex justify-end items-center space-x-2">
                                <form action="{{ route('admin.radio.approve', $track) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="flex items-center text-[10px] font-black uppercase bg-green-100 text-green-600 px-3 py-1.5 rounded hover:bg-green-200 transition-colors">
                                        Approve ✅
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>

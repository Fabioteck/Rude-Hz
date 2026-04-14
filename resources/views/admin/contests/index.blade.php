<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gestione Contest') }}
            </h2>
            <a href="{{ route('admin.contests.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 transition ease-in-out duration-150">
                + Nuovo Contest
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-gray-200 bg-gray-50">
                                    <th class="px-4 py-3 text-xs uppercase font-bold text-gray-600">Immagine</th>
                                    <th class="px-4 py-3 text-xs uppercase font-bold text-gray-600">Titolo / Slug</th>
                                    <th class="px-4 py-3 text-xs uppercase font-bold text-gray-600 text-center">Iscritti</th>
                                    <th class="px-4 py-3 text-xs uppercase font-bold text-gray-600 text-center">Stato</th>
                                    <th class="px-4 py-3 text-xs uppercase font-bold text-gray-600 text-right">Azioni</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($contests as $contest)
                                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                        <td class="px-4 py-3">
                                            @if($contest->image_path)
                                                <img src="{{ asset('storage/' . $contest->image_path) }}" class="h-12 w-20 object-cover rounded shadow-sm">
                                            @else
                                                <div class="h-12 w-20 bg-gray-200 flex items-center justify-center rounded text-[10px] text-gray-400">NO IMG</div>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="text-sm font-bold text-gray-800">{{ $contest->title }}</div>
                                            <div class="text-xs text-gray-500 font-mono">{{ $contest->slug }}</div>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <span class="px-2 py-1 bg-blue-50 text-blue-700 rounded-full text-xs font-bold">
                                                {{ $contest->tracks_count }} tracce
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            @if($contest->is_active)
                                                <span class="text-green-500 text-xs font-bold uppercase">● Attivo</span>
                                            @else
                                                <span class="text-red-400 text-xs font-bold uppercase">○ Off</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-right text-sm">
                                            <div class="flex justify-end space-x-2">
                                                <a href="{{ route('admin.contests.edit', $contest) }}" class="text-indigo-600 hover:text-indigo-900">Modifica</a>
                                                <form action="{{ route('admin.contests.destroy', $contest) }}" method="POST" onsubmit="return confirm('Sei sicuro?');">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Elimina</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                                            Nessun contest creato. <a href="{{ route('admin.contests.create') }}" class="text-indigo-600 underline">Crea il primo ora.</a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

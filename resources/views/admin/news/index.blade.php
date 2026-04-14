<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Redazione News</h2>
            <a href="{{ route('admin.news.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-bold text-sm hover:bg-indigo-700">+ Nuova News</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border">
                <table class="w-full text-left">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="p-4 border-b text-xs font-bold uppercase text-gray-500">Titolo</th>
                            <th class="p-4 border-b text-xs font-bold uppercase text-gray-500">Stato</th>
                            <th class="p-4 border-b text-xs font-bold uppercase text-gray-500">Data</th>
                            <th class="p-4 border-b text-xs font-bold uppercase text-gray-500 text-right">Azioni</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($news as $article)
                        <tr class="hover:bg-gray-50">
                            <td class="p-4 border-b font-bold">{{ $article->title }}</td>
                            <td class="p-4 border-b">
                                <span class="{{ $article->is_published ? 'text-green-600' : 'text-gray-400' }} text-xs font-black uppercase">
                                    {{ $article->is_published ? 'Pubblicato' : 'Bozza' }}
                                </span>
                            </td>
                            <td class="p-4 border-b text-sm text-gray-500">{{ $article->created_at->format('d/m/y') }}</td>
                            <td class="p-4 border-b text-right">
                                <a href="{{ route('admin.news.edit', $article) }}" class="text-indigo-600 font-bold hover:underline">Modifica</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="p-4">{{ $news->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>

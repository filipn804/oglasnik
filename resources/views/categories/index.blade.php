<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kategorije
        </h2>
    </x-slot>

    <div class="py-12 px-20">

        @if(Session::has('message'))
            <div class="bg-green-300 text-green-700 rounded px-2 py-3">
                {{Session::get('message')}}
            </div>
        @endif

        <div class="grid justify-items-stretch my-3">
            <a href="{{route('categories.create')}}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 flex justify-self-end">Kreiraj Kategoriju</a>
        </div>

        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                    <th class="relative px-6 py-3"></th>
                    <th class="relative px-6 py-3"></th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($categories as $category)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{$category->id}}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{$category->title}}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{route('categories.edit', [$category->id])}}" class="text-blue-500">Ažuriraj</a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <form method="post" action="{{route('categories.destroy', [$category->id])}}" id="deleteForm{{$category->id}}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500" onclick="event.preventDefault(); if(confirm('Are you sure to delete?')) {document.getElementById('deleteForm{{$category->id}}').submit();} else {return false;} ">Obriši</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-6 py-4 whitespace-nowrap">Trenutno nema kategorija</td></tr>
                @endforelse
            </tbody>
        </table>

            <div class="my-3">
                {{$categories->links()}}
            </div>
    </div>
</x-app-layout>

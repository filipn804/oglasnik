<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ads
        </h2>
    </x-slot>

    <div class="py-12 px-20">

        @if(Session::has('message'))
            <div class="bg-green-300 text-green-700 rounded px-2 py-3">
                {{Session::get('message')}}
            </div>
        @endif

        <div class="grid justify-items-stretch my-3">
            <a href="{{route('ads.create')}}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 flex justify-self-end">Create Ad</a>
        </div>

        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                <th class="relative px-6 py-3"></th>
                <th class="relative px-6 py-3"></th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            @forelse($ads as $ad)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{$ad->id}}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <img src="{{ url('/') . '/uploads/' . $ad->image }}" width="200" />
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">{{$ad->title}}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{$ad->category->title}}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{$ad->price}}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{route('ads.edit', [$ad->id])}}" class="text-blue-500">Edit</a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <form method="post" action="{{route('ads.destroy', [$ad->id])}}" id="deleteForm{{$ad->id}}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500" onclick="event.preventDefault(); if(confirm('Are you sure to delete?')) {document.getElementById('deleteForm{{$ad->id}}').submit();} else {return false;} ">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="px-6 py-4 whitespace-nowrap">No ads to display</td></tr>
            @endforelse
            </tbody>
        </table>

            <div class="my-3">
        {{$ads->links()}}
            </div>

    </div>
</x-app-layout>
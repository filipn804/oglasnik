<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kreiraj Oglas
        </h2>
    </x-slot>

    <div class="py-12 px-20">

        <form method="post" action="{{route('ads.store')}}" enctype="multipart/form-data">
            @csrf

            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                    <div class="grid grid-cols-3 gap-6">
                        <div class="col-span-3 sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">
                                Naslov
                            </label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <input type="text" name="title" value="{{old('title')}}" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300 @error('title') border-red-500 @enderror" placeholder="Naslov">
                            </div>
                            @error('title')
                            <div class="text-red-600">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="col-span-3 sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">
                                Sadržaj
                            </label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <textarea name="content" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300 @error('content') border-red-500 @enderror">{{old('content')}}</textarea>
                            </div>
                            @error('content')
                            <div class="text-red-600">{{$message}}</div>
                            @enderror
                        </div>

                         <div class="col-span-3 sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">
                                Cijena (cijeli broj)
                            </label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <input type="text" name="price" value="{{old('price')}}" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300 @error('title') border-red-500 @enderror" placeholder="Cijena">
                            </div>
                            @error('price')
                            <div class="text-red-600">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="col-span-3 sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">
                                Količina na zalihi
                            </label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <input type="number" min="1" name="quantity" value="{{old('quantity')}}" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300 @error('quantity') border-red-500 @enderror" placeholder="Količina">
                            </div>
                            @error('quantity')
                            <div class="text-red-600">{{$message}}</div>
                            @enderror
                        </div>


                        <div class="col-span-3 sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">
                                Kategorija
                            </label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <select name="category_id" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300 @error('category_id') border-red-500 @enderror">
                                    <option value="" {{old('category_id')=='' ? 'selected':''}}>--- Odaberi ---</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}" {{old('category_id')==$category->id ? 'selected':''}}>{{$category->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('category_id')
                            <div class="text-red-600">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="col-span-3 sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">
                                Slika
                            </label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <input type="file" name="image" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300 @error('title') border-red-500 @enderror">
                            </div>
                            @error('image')
                            <div class="text-red-600">{{$message}}</div>
                            @enderror
                        </div>

                    </div>

                </div>
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Kreiraj Oglas
                    </button>
                </div>
            </div>

        </form>

    </div>
</x-app-layout>

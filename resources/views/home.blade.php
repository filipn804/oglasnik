@extends('layouts.main')

@section('content')

    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
{{--        @include('layouts.navigation')--}}



        <!-- Page Content -->
        <main>





                <div class="p-10 grid grid-cols-1 sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3 gap-5">
                    <!--Card 1-->
                    @foreach ($ads as $ad)
                        <div class="rounded overflow-hidden shadow-lg">
                            <img class="w-full" src="{{ url('/') . '/uploads/' . $ad->image }}" alt="Mountain">
                            <div class="px-6 py-4">
                                <div class="font-bold text-xl mb-2">{{ $ad->title }}</div>
                                <div class="font-bold text-xl mb-2">{{ $ad->price }}</div>
                                <p class="text-gray-700 text-base">
                                    {{ nl2br($ad->content) }}
                                </p>
                            </div>
                            <div class="px-6 pt-4 pb-2">
                                <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2"><a href="/category/{{ $ad->category_id }}">{{$ad->category->title}}</a></span>
                                <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2"><a href="/category/{{ $ad }}">{{$ad->title}}</a></span>
                            </div>
                        </div>
                    @endforeach

                </div>


        </main>
    </div>
@endsection


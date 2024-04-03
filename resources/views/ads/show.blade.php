@extends('layouts.main')
@section('title', $ad->title)
@section('content')

    <div class="min-h-screen bg-white dark:bg-gray-900">
        @include('layouts.navigation')

        @php
            $show = true;
            if(auth()->user()) {
              $show = $ad->quantity > 0 && auth()->user()->id != $ad->user_id;
            } else {
              $show = $ad->quantity > 0;
            }
        @endphp
        <section class="text-gray-700 body-font overflow-hidden bg-white">
            <div class="container px-5 py-24 mx-auto">
                <div class="lg:w-4/5 mx-auto flex flex-wrap">
                    <img alt="{{ $ad->title }}"
                         class="lg:w-1/2 w-full object-cover object-center rounded border border-gray-200"
                         src="{{ url('/') . '/uploads/' . $ad->image }}">
                    <div class="lg:w-1/2 w-full lg:pl-10 lg:py-6 mt-6 lg:mt-0">
                        <h1 class="text-gray-900 text-3xl title-font font-medium mb-1">{{ $ad->title }}</h1>
                        <p class="leading-relaxed">{!! nl2br($ad->content) !!}</p>

                        <div class="flex mt-3">
                            <span class="title-font font-medium text-2xl text-gray-900">Cijena: {{ number_format($ad->price, 2)  }} €</span>
                        </div>
                        <div class="flex mt-3">
                            <span class="title-font font-medium text-2xl text-gray-900">Prodavač: {{ $user->name }}</span>
                        </div>
                        @if ($show)
                            <div class="flex mt-3">
                            <span
                                class="inline-block bg-blue-200 rounded-full px-3 py-1 text-sm font-semibold text-white-700 mr-2 mb-2">
                                <a href="{{ route('add_to_cart', $ad->id) }}">Dodaj u košaricu</a>
                            </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @if ($relatedAds)
                <div class="text-black mt-5 pt-5 ml-5 pl-5">
                    <h2 class="mb-2 mt-0 text-5xl font-medium leading-tight text-primary6 mt5">Vezani Oglasi</h2>
                </div>
                <div class="p-10 grid grid-cols-1 sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3 gap-5">
                    @foreach($relatedAds as $ad)
                        <div class="rounded overflow-hidden shadow-lg max-w-lg bg-white">
                            <a href="/ads/{{ $ad->id }}">
                                <img class="w-full h-48 object-cover" src="{{ url('/') . '/uploads/' . $ad->image }}"
                                     alt="{{ $ad->title }}">
                            </a>
                            <div class="px-6 py-4">
                                <div class="font-bold text-xl mb-2"><a href="/ads/{{ $ad->id }}">{{ $ad->title }}</a>
                                </div>
                                <div class="font-bold text-xl mb-2">{{ number_format($ad->price, 2) }} €</div>
                                <p class="text-gray-700 text-base">
                                    {{ nl2br($ad->content) }}
                                </p>
                            </div>
                            <div class="px-6 pt-4 pb-2">
                            <span
                                class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2"><a
                                    href="/category/{{ $ad->category_id }}">{{$ad->category->title}}</a></span>
                                @if ($ad->quantity > 0)
                                    <span
                                        class="inline-block bg-blue-200 rounded-full px-3 py-1 text-sm font-semibold text-white-700 mr-2 mb-2 flex-grow"><a
                                            href="{{ route('add_to_cart', $ad->id) }}">Dodaj u košaricu</a></span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>
    </div>
@endsection


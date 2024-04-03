@extends('layouts.main')

@section('content')

    <div class="min-h-screen bg-[#F3F4F6]-100 dark:bg-[#F3F4F6]-900">
        @include('layouts.navigation')
        <!-- Page Content -->
        <main class="container mx-auto">
            <div class="p-10 grid grid-cols-1 sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3 gap-5">
                <!--Card 1-->
                @if($ads)
                    @foreach ($ads as $ad)
                        @php
                            $show = true;
                            if(auth()->user()) {
                              $show = $ad->quantity > 0 && auth()->user()->id != $ad->user_id;
                            } else {
                              $show = $ad->quantity > 0;
                            }
                        @endphp
                        <div class="rounded-lg overflow-hidden shadow-lg max-w-lg bg-white">
                            <a href="/ads/{{ $ad->id }}">
                                <img class="w-full h-48 object-cover" src="{{ url('/') . '/uploads/' . $ad->image }}"
                                     alt="{{ $ad->title }}">
                            </a>
                            <div class="px-6 py-4">
                                <div class="font-bold text-xl mb-2"><a href="/ads/{{ $ad->id }}">{{ $ad->title }}</a>
                                </div>
                                <div class="font-bold text-xl mb-2">{{ number_format($ad->price, 2) }} €</div>
                                <p class="text-gray-700 text-base">
                                    {!!  Str::limit(nl2br($ad->content), $limit = 150, $end = '...') !!}
                                </p>
                            </div>
                            <div class="px-6 pt-4 pb-2">
                                <span
                                        class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2 flex-grow"><a
                                            href="/category/{{ $ad->category_id }}">{{$ad->category->title}}</a></span>
                                @if ($show)
                                    <span
                                            class="inline-block bg-blue-200 rounded-full px-3 py-1 text-sm font-semibold text-white-700 mr-2 mb-2 flex-grow"><a
                                                href="{{ route('add_to_cart', $ad->id) }}">Dodaj u košaricu</a></span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endif

            </div>
        </main>
    </div>
@endsection


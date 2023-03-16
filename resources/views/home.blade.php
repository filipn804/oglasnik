@extends('layouts.guest')

@section('content')

    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
{{--        @include('layouts.navigation')--}}



        <!-- Page Content -->
        <main>

            @foreach ($ads as $ad)
                <p>This is ad {{ $ad->title}}</p>
            @endforeach

        </main>
    </div>
@endsection


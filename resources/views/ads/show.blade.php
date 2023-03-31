@extends('layouts.main')

@section('content')

    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        {{--        @include('layouts.navigation')--}}



        <!-- Page Content -->
        <main>





            <div class="p-10 grid grid-cols-1 sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3 gap-5">
                <!--Card 1-->
               <h2>{{ $ad->title }}</h2>

                <div class="bg-white rounded-md list-none  text-center ">
                    <li class="py-3 border-b-2"><a href="#" class="list-none  hover:text-indigo-600">Title</a></li>
                    <li class="py-3 border-b-2"><a href="#" class="list-none  hover:text-indigo-600">Content</a></li>
                    <li class="py-3 border-b-2"><a href="#" class="list-none  hover:text-indigo-600">Price</a></li>
                </div>
            </div>
        </main>
    </div>
@endsection


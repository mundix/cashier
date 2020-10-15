@extends('layouts.app')

@section('content')
<main class="sm:container sm:mx-auto sm:mt-10">
    <div class="w-full sm:px-6">

        @if (session('status'))
            <div class="text-sm border border-t-8 rounded text-green-700 border-green-600 bg-green-100 px-3 py-4 mb-4" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <section class="flex flex-col break-words bg-white sm:border-1 sm:rounded-md sm:shadow-sm sm:shadow-lg">

            <header class="font-semibold bg-gray-200 text-gray-700 py-5 px-6 sm:py-6 sm:px-8 sm:rounded-t-md">
                Billing
            </header>

            <div class="w-full p-6">
                <p class="text-gray-700">
                    You are now in a free trial, please choos plan to Upgrade

                </p>
            </div>
            <div class="px-2">
                <div class="flex mb-4 -mx-2">
                    @foreach($plans ?? [] as $plan)
                        <div class="w-1/3 bg-gray-400 h-12 px-2 mx-2">
                            <div class="max-w-sm rounded overflow-hidden shadow-lg card">
                                <div class="px-6 py-4">
                                <div class="font-bold text-xl mb-5">{{$plan->name}}</div>
                                <p class="text-gray-700 text-base">
                                    ${{$plan->price/100}} / month
                                </p>
                                </div>
                                <div class="px-6 pt-4 pb-2 mb-4">
                                    <a href="{{route('checkout', $plan->id)}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">Suscribe to {{$plan->name}}</a>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>

        </section>
    </div>
</main>
@endsection

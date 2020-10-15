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
                Suscribe to {{$plan->name}}
            </header>

            <div class="w-full p-6">
                <div class="flex mb-4 -mx-2">
                    <form action="{{route('checkout.process')}}" method='POST'>
                        @csrf
                        <input type="hidden" name='billing_plan_id' value="{{$plan->id}}">
                        {{-- The stripe part copy and paste from the laravel stripe form part --}}
                        <input id="card-holder-name" type="text">
                        <!-- Stripe Elements Placeholder -->
                        <div id="card-element"></div> <!-- this fill with dynamic js -->

                        <button id="card-button" data-secret="{{ $intent->client_secret  }}">
                            Pay ${{number_format($plan->price/100, 2)}}
                        </button>
                    </form>
            </div>
            </div>
        </section>
    </div>
</main>
@endsection

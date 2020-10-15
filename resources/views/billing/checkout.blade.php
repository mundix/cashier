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
                    <form action="{{route('checkout.process')}}" method='POST' class="w-full max-w-sm">
                        @csrf
                        <div class="md:flex md:items-center mb-6">
                            <div class="md:w-1/3">
                              <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="inline-full-name">
                                Billing Plan ID
                              </label>
                            </div>
                            <div class="md:w-2/3">
                              <input type="hidden" name='billing_plan_id' value="{{$plan->id}}"
                              class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                              id="inline-full-name"
                              >
                            </div>
                        </div>

                        {{-- The stripe part copy and paste from the laravel stripe form part --}}
                        <div>
                            <div class="md:flex md:items-center mb-6">
                                <div class="md:w-1/3">
                                  <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="inline-full-name">
                                    Card Holder Name
                                  </label>
                                </div>
                                <div class="md:w-2/3">
                                  <input type="text"
                                  class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                                  id="card-holder-name"
                                  >
                                </div>
                            </div>

                        </div>
                        <!-- Stripe Elements Placeholder -->
                        <div id="card-element"></div> <!-- this fill with dynamic js -->

                        <div class="md:flex md:items-center">
                            <div class="md:w-1/3"></div>
                            <div class="md:w-2/3">
                              <button
                              id="card-button" data-secret="{{ $intent->client_secret  }}"
                              class="shadow bg-purple-500 hover:bg-purple-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded" type="button">
                              Pay ${{number_format($plan->price/100, 2)}}
                              </button>
                            </div>
                          </div>
                    </form>
            </div>
            </div>
        </section>
    </div>
</main>
@endsection

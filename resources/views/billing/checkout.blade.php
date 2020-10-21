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
                    <form action="{{route('checkout.process')}}" method='POST' class="w-full max-w-sm" id="checkout-form">
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
                              <input type="hidden" name="payment-method" id="payment-method" value="">
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
                              id="card-button"
                              {{-- This data-secret is used on the jquery stripe.confirmCardSetup  --}}
                              {{-- data-secret="{{ $intent->client_secret  }}" --}}
                              class="shadow bg-purple-500 hover:bg-purple-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded"
{{--                              type="submit"--}}
                              >
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
@push('scripts')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        $( document ).ready(function() {
        let stripe = Stripe("{{ env('STRIPE_KEY') }}")
        let elements = stripe.elements()
        let style = {
          base: {
            color: '#32325d',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
              color: '#aab7c4'
            }
          },
          invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
          }
        }
        let card = elements.create('card', {style: style})
        card.mount('#card-element');

        let paymentMethod = null;

        $('#checkout-form').on('submit', function(e) {

            if( paymentMethod ) {
                return true;
            }

            stripe.confirmCardSetup(
                "{{ $intent->client_secret }}",
                {
                    payment_method: {
                        card: card,
                        billing_details: { name: $('#card-holder-name').val() }
                    }
                }
            ).then( function( result) {

                if ( result.error) {
                    console.log( result);
                    alert( 'error');
                } else {
                    paymentMethod = result.setupIntent.payment_method;
                    $('#payment-method').val(paymentMethod);
                    $('#checkout-form').onsubmit();
                }
            });
            return false;
        });
      });
    </script>
@endpush
@push('styles')
<style>
    .StripeElement {
        box-sizing: border-box;
        height: 40px;
        padding: 10px 12px;
        border: 1px solid transparent;
        border-radius: 4px;
        background-color: white;
        box-shadow: 0 1px 3px 0 #e6ebf1;
        -webkit-transition: box-shadow 150ms ease;
        transition: box-shadow 150ms ease;
    }
    .StripeElement--focus {
        box-shadow: 0 1px 3px 0 #cfd7df;
    }
    .StripeElement--invalid {
        border-color: #fa755a;
    }
    .StripeElement--webkit-autofill {
        background-color: #fefde5 !important;
    }
</style>
@endpush
@endsection

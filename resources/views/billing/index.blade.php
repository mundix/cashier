@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">My Plan</div>

                    <div class="card-body">
                        @if (session('message'))
                            <div class="alert alert-info">{{ session('message') }}</div>
                        @endif

{{--                        @if (is_null($currentPlan))--}}
{{--                            You are now on Free Plan. Please choose plan to upgrade:--}}
{{--                            <br /><br />--}}
{{--                        @elseif ($currentPlan->trial_ends_at)--}}
{{--                            <div class="alert alert-info">Your trial will end on {{ $currentPlan->trial_ends_at->toDateString() }} and your card will be charged.</div>--}}
{{--                            <br /><br />--}}
{{--                        @endif--}}
                        <div class="row" id="plans_monthly">
                            @foreach ($plans as $plan)
                                <div class="col-md-4 text-center">
                                    <h3>{{ $plan->name }}</h3>
                                    <b>${{ number_format($plan->price / 100, 2) }} / month</b>
                                    <hr />
                                    <a href="{{ route('checkout', $plan->id) }}" class="btn btn-primary">Subscribe to {{ $plan->name }}</a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

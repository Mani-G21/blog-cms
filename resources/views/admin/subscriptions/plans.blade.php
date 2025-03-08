@extends('admin.layouts.app')
@section('page-level-styles')
    <style>
        .custom-hover:hover {
            color: black;

        }
    </style>
@endsection
@section('main-content')
    <div class="card">
        <div class="card-header mb-3">
            <h1>Select a subscription plan</h1>
        </div>
        <div class="container mt-3">
            <div class="card-deck mb-3 text-center">

                @foreach ($plans as $plan)
                    {{-- <strong>{{ $plan->name }}</strong> - ${{ number_format($plan->price) }} per
                        {{ $plan->interval }}<br>
                        <a href={{ route('subscriptions.checkout', $plan->id) }}
                            class="button button-sm button-pasific hover-ripple-out btn-sm">Subscribe Now</a> --}}

                    <div class="card mb-4 box-shadow @if ($plan->id == 3) {{ 'bg-primary text-white' }} @endif">
                        <div class="card-header @if ($plan->id == 3) text-primary @endif" style="height: 30%">
                            <h4 class="my-0 font-weight-normal">{{ $plan->name }}</h4>
                        </div>
                        <div class="card-body">
                            <h1 class="card-title pricing-card-title">${{ number_format($plan->price) }} <small
                                    class="text-@if ($plan->id == 3) white @endif">{{ $plan->interval }}</small>
                            </h1>
                            <ul class="list-unstyled mt-3 mb-4">
                                <li>- Generate articles through AI</li>
                                <li>- {{ $plan->articles_per_month }} Articles</li>
                                <li>- Recurring</li>
                                <li>- Refreshes {{ $plan->interval }}</li>
                                @if ($plan->id == 3)
                                    <li>- Savings offer</li>
                                @endif
                            </ul>
                            <a href="{{ route('subscriptions.checkout', $plan->id) }}"
                                class="btn btn-lg btn-block btn-outline-primary mb-4
                                        @if ($plan->id == 3) bg-white custom-hover @endif">
                                Subscribe
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

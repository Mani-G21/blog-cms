@extends('admin.layouts.app')

@section('main-content')
    <h1>Select a subscription plan</h1>
    <ul>
        @foreach ($plans as $plan)
            <li>
                <strong>{{$plan->name}}</strong> - ${{number_format($plan->price)}} per {{$plan->interval}}<br>
                <a href={{route('subscriptions.checkout', $plan->id)}} class="button button-sm button-pasific hover-ripple-out btn-sm">Subscribe Now</a>
            </li>
        @endforeach
    </ul>
@endsection

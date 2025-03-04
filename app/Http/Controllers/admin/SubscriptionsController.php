<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Tag;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class SubscriptionsController extends Controller
{
    public function showPlans() {
        $plans = Plan::all();
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.subscriptions.plans', compact(['plans', 'categories', 'tags']));
    }

    public function createCheckoutSession($planId) {
        $plan = Plan::findOrFail($planId);

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price' => $plan->stripe_price_id,
                'quantity' => 1,
            ]],
            'mode' => 'subscription',
            'success_url' => route('subscription.success', ['planId' => $planId] ) . '/?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('subscription.cancel'),
            ]);

            return redirect($session->url);
    }

    public function success(Request $request, $planId) {
        Subscription::create([
            'user_id' => auth()->id(),
            'plan_id' => $planId,
            'stripe_session_id' => $request->session_id,
            'status' => 'active',
            'articles_remaining' => Plan::find($planId)->articles_per_month,
        ]);
        return redirect()->route('admin.dashboard')->with('success', 'Subscription activated!');
    }

    public function cancel() {
        return view('subscription.cancel');
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Subscription $subscription)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subscription $subscription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subscription $subscription)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subscription $subscription)
    {
        //
    }
}

<?php

use App\Models\Plan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('stripe_plan_id');
            $table->string('stripe_price_id');
            $table->string('interval');
            $table->unsignedInteger('price');
            $table->unsignedInteger('articles_per_month');
            $table->timestamps();
        });

        $plans = collect([
            ['name' => 'Basic Monthly Plan', 'stripe_plan_id' => 'prod_Rru9YR8fhFUXJZ', 'stripe_price_id' => 'price_1QyALYJg2PxnO5v3mZ1ItCFu','interval' => 'monthly', 'price' => 10, 'articles_per_month' => 100],
            ['name' => 'Pro Monthly Plan', 'stripe_plan_id' => 'prod_RruA6IWkCJ80lv', 'stripe_price_id' => 'price_1QyAMOJg2PxnO5v3inhrbKpr', 'interval' => 'monthly', 'price' => 29, 'articles_per_month' => 500],
            ['name' => 'Basic Yearly Plan (10% off)', 'stripe_plan_id' => 'prod_RruBd7ilvHtwKx','stripe_price_id' => 'price_1QyANEJg2PxnO5v3Hr5yiPpd', 'interval' => 'yearly', 'price' => 108, 'articles_per_month' => 1200],
            ['name' => 'Pro Yearly Plan (10% off)', 'stripe_plan_id' => 'prod_RruCTI7QAuA2GB', 'stripe_price_id' => 'price_1QyAOOJg2PxnO5v3mJuQpbgc','interval' => 'yearly', 'price' => 313, 'articles_per_month' => 6000]
        ]);

        $plans->each(function($plan){
            Plan::create($plan);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};

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
            $table->string('interval');
            $table->unsignedInteger('price');
            $table->unsignedInteger('articles_per_month');
            $table->timestamps();
        });

        $plans = collect([
            ['name' => 'Basic Monthly Plan', 'stripe_plan_id' => 'prod_Rru9YR8fhFUXJZ', 'interval' => 'monthly', 'price' => 10, 'articles_per_month' => 100],
            ['name' => 'Pro Monthly Plan', 'stripe_plan_id' => 'prod_RruA6IWkCJ80lv', 'interval' => 'monthly', 'price' => 29, 'articles_per_month' => 500],
            ['name' => 'Basic Yearly Plan (10% off)', 'stripe_plan_id' => 'prod_RruBd7ilvHtwKx', 'interval' => 'yearly', 'price' => 108, 'articles_per_month' => 1200],
            ['name' => 'Pro Yearly Plan (10% off)', 'stripe_plan_id' => 'prod_RruCTI7QAuA2GB', 'interval' => 'yearly', 'price' => 313, 'articles_per_month' => 6000]
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

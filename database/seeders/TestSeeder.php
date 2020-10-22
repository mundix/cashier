<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Database\Seeder;


class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
		$name = 'Bronze Plan';
		$price = 999;
	    $data['slug'] = strtolower($name);
	    $data['name'] = $name;
	    $data['price'] = $price *100;

	    //create stripe product
	    $stripeProduct = $stripe->products->create([
		    'name' => $name,
	    ]);

	    //Stripe Plan Creation
	    $stripePlanCreation = $stripe->plans->create([
		    'amount' => $price,
			'currency' => 'usd',
		    'interval' => 'month', //  it can be day,week,month or year
		    'product' => $stripeProduct->id,
	    ]);

	    $data['stripe_plan'] = $stripePlanCreation->id;

	    Plan::create($data);

	    echo 'plan has been created';

//        $user = User::first();
//        $localPlan = App\Models\Plan::first();
//	    Stripe\Planan::create(array(
//			    "amount" => $localPlan->price,
//			    "interval" => "month",
//			    "name" => $localPlan->plan,
//			    "currency" => "usd",
//			    "id" => "bronze")
//	    );
    }
}

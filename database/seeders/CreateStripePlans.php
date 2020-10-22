<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Database\Seeder;

class CreateStripePlans extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

    	$user = User::first();
//	    if ($user->hasPaymentMethod()) {
		    // cus_IFLFjx7y25H5Or

	        $paymentMethods = $user->paymentMethods();
	        $user->customers->retrieve(
		    $user->stripe_customer_id, []
		    );
//	        dd($paymentMethods);
//	    }
//    	dd($user->createAsStripeCustomer());
//        foreach(Plan::get() as $plan)
//        {
//	    $plan = Plan::find(2);
//	        $sunscription = \Stripe\Plan::create(
//	        	[
//			        "amount" => $plan->price,
//			        "interval" => "month",
//			        "product" => 'prod_IF7cjHqkjlYIHK',
//			        "currency" => "usd",
//			        "id" => "silver"
//		        ]
//	        );

	    $stripe = new \Stripe\StripeClient(
		    'sk_test_obfuscated_offline_key'
	    );
	    $plans = $stripe->plans->all(['limit' => 3]);
	    dd($plans);

//        }
    }
}

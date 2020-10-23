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

    	$this->createBronzePlan();
//    	$this->createSilverPlan();
		$user = User::first();



//		dd($user->defaultPaymentMethod());
	    #if user has paymentmethod
	    if($user->subscription('default')->active())
	    {
		    if($user->subscription('default')->active())
		    {
			    $invoices = $user->invoices();
			    dd($invoices);
		    }
	    	print "Subscription Actived \n";
//			dd($user->subscription('default')->items->first()->getAttributes());
			foreach($user->subscription('default')->items as $item)
			{
				print "Stripe Plan ID: ".$item->stripe_plan;
				print "\n";
			}
		    $user->subscription('default')->cancelNow();
		    if ($user->subscription('default')->cancelled()) {
			    print "Subscription Plan was canceled \n";
		    }else{
		    	print "Plan Wasn't Canceled \n";
		    }
	    }

	    if($user->hasDefaultPaymentMethod()) {
			print "Has PaymentMethod \n";
//			dd($user->subscription('default')->items->first());
		    #subscription is active
			dd();
	    }else{
	    	print "need to add payment method credit card \n";
	    }
    }


    public function createBronzePlan()
    {
	    $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
	    $name = 'Bronze Plan';
	    $price = 999;
	    $data['slug'] = strtolower($name);
	    $data['name'] = $name;
	    $data['price'] = $price / 100;

	    //create stripe product
	    $stripeProduct = $stripe->products->create([
		    'name' => $name,
	    ]);

	    //Stripe Plan Creation
	    $stripePlanCreation = $stripe->plans->create([
		    'amount' => 999,
		    'currency' => 'usd',
		    'interval' => 'month', //  it can be day,week,month or year
		    'product' => $stripeProduct->id,
	    ]);

	    $data['stripe_plan'] = $stripePlanCreation->id;

	    Plan::create($data);

	    echo 'plan has been created';
    }

    public function createSilverPlan()
    {
	    $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
	    $name = 'Silver Plan';
	    $price = 1499;
	    $data['slug'] = strtolower($name);
	    $data['name'] = $name;
	    $data['price'] = $price / 100;

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
    }
}

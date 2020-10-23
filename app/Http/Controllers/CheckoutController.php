<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;

class CheckoutController extends Controller
{
	public function checkout($plan_id)
	{
		$plan = Plan::findOrFail($plan_id);
		$intent = auth()->user()->createSetupIntent(); //this came from  User model billable
		return view('billing.checkout', compact('plan', 'intent'));
	}

	/**
	 * This works 100% User subscriptions with a plan Monthly
	 * @param POST billing_plan_id  (This plan id is the plan of local db
	 *
	*/
	public function processCheckout(Request $request)
	{
		$plan = Plan::findOrFail($request->get('billing_plan_id'));

		$user = $request->user();

		# Canceled Previous Subscription
		if($user->subscription('default')->active())
		{
			$invoices = $user->invoices();
			dd($invoices);
		}

		$paymentMethod = $request->input('payment-method');

		$user->createOrGetStripeCustomer();
		$user->updateDefaultPaymentMethod($paymentMethod);
		$response  = $user->newSubscription('default', $plan->stripe_plan)
			->create($paymentMethod, [
				'email' => $user->email,
			]);
		dd($response);
//		return redirect()->route('home')->with('success', 'Your plan subscribed successfully');

	}
}

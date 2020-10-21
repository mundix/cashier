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

	public function processCheckout(Request $request)
	{
//		return $request->all();
		$user = auth()->user();
		$plan = Plan::findOrFail($request->input('billing_plan_id'));
		//stripe_plan_id => prod_IF7cjHqkjlYIHK on the db
		try {
			$user->newSubscription($plan->name, $plan->strip_plan_id)->create($request->input('payment-method'));
			return redirect()->route('billing')->with('success', 'Suscribe successfully');
		}catch (\Exception $e) {
			return redirect()->back()->withErrors($e->getMessage());
		}
	}
}

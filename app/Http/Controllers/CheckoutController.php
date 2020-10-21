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
		return $request->all();
    }
}

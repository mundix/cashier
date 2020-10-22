<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class BillingController extends Controller
{

    public function index()
    {
        $plans = Plan::all();
	    $currentPlan = null;
        return view('billing.index', compact('plans', 'currentPlan'));
    }
}

<?php

use App\Http\Controllers\BillingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();

Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['middleware' => 'auth'], function(){
    Route::get('billing', [\App\Http\Controllers\BillingController::class, 'index'])->name('billing');
    Route::get('checkout/{plan_id}', [\App\Http\Controllers\CheckoutController::class, 'checkout'])->name('checkout');
    Route::post('checkout', [\App\Http\Controllers\CheckoutController::class, 'processCheckout'])->name('checkout.process');

    # ----------------------
    # From video tutorial
    # ----------------------
	Route::get('/home', [\App\Http\Controllers\HomeController::class,'index'])->name('home');
	Route::get('/plans', [\App\Http\Controllers\PlanController::class,'index'])->name('plans.index');
	Route::get('/plan/{plan}', [\App\Http\Controllers\PlanController::class,'show'])->name('plans.show');
	Route::post('/subscription', [\App\Http\Controllers\subscriptionController::class,'create'])->name('subscription.create');

	//Routes for create Plan
	Route::get('create/plan', [\App\Http\Controllers\subscriptionController::class,'createPlan'])->name('create.plan');
	Route::post('store/plan', [\App\Http\Controllers\subscriptionController::class.'storePlan'])->name('store.plan');


});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

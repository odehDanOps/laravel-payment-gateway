<?php

use Illuminate\Support\Facades\Route;
use Modules\Payments\Http\Controllers\PaymentsController;

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

Route::post('/stripe/checkout', [PaymentsController::class, 'checkoutStripePayment'])->name('stripe.checkout');
Route::post('/order/flutterwave/add', [PaymentsController::class, 'addFlutterwavePaymentOrder'])->name('paystack.addOrder');
Route::post('/flutterwave/checkout', [PaymentsController::class, 'checkoutFlutterwavePayment'])->name('paystack.checkout');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

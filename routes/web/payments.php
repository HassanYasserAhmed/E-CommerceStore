<?php

use App\Http\Controllers\Front\PaymentsController;
use App\Http\Controllers\StripeWebhooksController;
Route::middleware('auth')->group(function() {
Route::get('orders/{order}/pay', [PaymentsController::class, 'create'])
    ->name('orders.payment.create');
Route::post('orders/{order}/payment-intent', [PaymentsController::class, 'createStripePaymentIntent'])
    ->name('orders.payment-intent.create');
Route::get('orders/{order}pay/stripe/return', [PaymentsController::class, 'confirm'])
    ->name('stripe.return');
Route::any('stripe/webhook', [StripeWebhooksController::class, 'handle'])->name('stripe.webhook');
});
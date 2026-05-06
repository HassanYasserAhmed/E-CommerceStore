<?php

use App\Http\Controllers\Front\CheckoutController;

Route::middleware('auth')->group(function () {
    Route::get('checkout', [CheckoutController::class, 'create'])->name('checkout');
    Route::post('checkout', [CheckoutController::class, 'store']);
});

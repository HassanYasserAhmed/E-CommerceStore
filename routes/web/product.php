<?php

use App\Http\Controllers\Api\ProductsController;
use App\Http\Controllers\Front\ProductsController as FrontProductsController;

Route::get('/products', [ProductsController::class, 'index'])->name('product.index');
Route::get('/products/{product:slug}', [FrontProductsController::class, 'show'])->name('product.show');

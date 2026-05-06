<?php
namespace App\Repositories\Checkout;
use App\Models\Cart;

interface CheckoutRepository {
    public function Store($data,Cart $cart);
}
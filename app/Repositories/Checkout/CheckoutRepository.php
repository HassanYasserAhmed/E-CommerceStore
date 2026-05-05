<?php

use App\Models\Cart;

interface CheckoutRepository {
    public function Store($data,Cart $cart);
}
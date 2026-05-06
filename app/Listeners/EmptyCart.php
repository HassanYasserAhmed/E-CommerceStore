<?php

namespace App\Listeners;

use App\Models\Cart;

class EmptyCart
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle($event): void
    {
       $cart->empty();
    }
}

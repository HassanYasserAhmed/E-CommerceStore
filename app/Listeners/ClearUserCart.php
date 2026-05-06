<?php

namespace App\Listeners;

use App\Events\CartCleared;
use App\Repositories\Cart\CartRepository;
class ClearUserCart
{
    /**
     * Create the event listener.
     */
    public function __construct(protected CartRepository $cartRepository)
    {
        //
    }

    /**
     * Handle the event.
     */
     public function handle()
    {
       $this->cartRepository->empty();
    }
}

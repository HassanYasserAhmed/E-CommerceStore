<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class DeductProductQuantity
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    public function handle(OrderCreated $event): void
    {
        $order = $event->order;
        foreach ($order->products as $product) {
            $product->decrement('quantity', $product->pivot->quantity);

            // Product::where('id','=',$product->product_id)
            //     ->update([
            //             'quantity'=> DB::raw("quantity - {$product->quantity}")
            //         ]);
        }
    }
}

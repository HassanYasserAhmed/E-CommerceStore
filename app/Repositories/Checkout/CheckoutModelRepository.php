<?php
namespace App\Repositories\Checkout;

use App\Events\CartCleared;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class CheckoutModelRepository implements CheckoutRepository
{
    public function Store($data, Cart $cart)
    {
        $items = $cart->get()->groupBy('product.store_id')->all();

        DB::beginTransaction();
        try {
            foreach ($items as $store_id => $cart_items) {

                $order = Order::create(
                    [
                        'store_id' => $store_id,
                        'user_id' => Auth::id(),
                        'payment_method' => 'cod',
                    ]
                );

                foreach ($cart_items as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product->id,
                        'product_name' => $item->product->name,
                        'price' => $item->product->price,
                        'quantity' => $item->quantity,
                    ]);
                }

                foreach ($data['addr'] as $type => $address) {
                    $address['type'] = $type;
                    $order->addresses()->create($address);
                }
            }
            //  event('order.created',$order,Auth::user());
            // event(new OrderCreated($order));

            DB::commit();
            event (new CartCleared());
            return $order;

        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}

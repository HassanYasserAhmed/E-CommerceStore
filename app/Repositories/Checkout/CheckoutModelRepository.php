<?php

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;

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

                foreach ($data->post('addr') as $type => $address) {
                    $address['type'] = $type;
                    $order->addresses()->create($address);
                }
            }
            //  event('order.created',$order,Auth::user());
            // event(new OrderCreated($order));

            DB::commit();

            return redirect()->route('orders.payment.create', $order->id);
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}

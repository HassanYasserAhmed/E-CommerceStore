<?php

namespace App\Repositories\Order;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Repositories\Cart\CartRepository;

class OrderModelRepository implements OrderRepository
{
    public function __construct(
        protected OrderRepository $orderRepository,
        protected CartRepository $cartRepository
    ) {}

    public function store($user_id, $data, Cart $cart)
    {
        return  Order::create([
            'user_id' => $user_id,
            'payment_method' => 'Stripe',
        ]);
    }
    public function storeOrderItems($order_id, $items)
    {
        foreach ($items as $item) {
            OrderItem::create([
                'order_id' => $order_id,
                'product_id' => $item->product->id,
                'product_name' => $item->product->name,
                'price' => $item->product->price,
                'quantity' => $item->quantity,
            ]);
        }
    }
    public function storeOrderAddresses(Order $order, $data)
    {
        foreach ($data['addr'] as $type => $address) {
            $address['type'] = $type;
            $order->addresses()->create($address);
        }
    }
}

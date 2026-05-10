<?php

namespace App\Repositories\Order;

use App\Models\Cart;
use App\Models\Order;

interface OrderRepository
{
    public function store($user_id, $data, Cart $cart);
    public function storeOrderItems($order_id,$items);
    public function storeOrderAddresses(Order $order,$data);
}

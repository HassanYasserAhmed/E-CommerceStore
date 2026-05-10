<?php

namespace App\Services;

use App\Events\CartCleared;
use App\Models\Cart;
use App\Repositories\Cart\CartRepository;
use App\Repositories\Order\OrderRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function __construct(
        protected CartRepository $cartRepository,
        protected OrderRepository $orderRepository
    ) {}
    public function store($data,Cart $cart)
    {
        return DB::transaction(function () use ($data, $cart) {

            $items = $this->cartRepository->getCartItems($cart);

            $order = $this->orderRepository->store(Auth::id(), $data, $cart);

            $this->orderRepository->storeOrderItems($order->id, $items);

            $this->orderRepository->storeOrderAddresses($order, $data);

            event(new CartCleared());

            return $order;
        });
    }
}

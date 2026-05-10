<?php

namespace App\Http\Controllers\Front;

use App\Http\Requests\Web\StoreOrderRequest;
use App\Models\Cart;
use App\Services\OrderService;

class OrderController
{
    public function __construct(protected OrderService $orderService) {}
    public function store(StoreOrderRequest $request, Cart $cart)
    {
        $data = $request->validated();
        $order = $this->orderService->store($data, $cart);
        if (! $order) {
            redirect()->route('home')->with([
                'success' => 'Order Created Successfully'
            ]);
        }
    }
}

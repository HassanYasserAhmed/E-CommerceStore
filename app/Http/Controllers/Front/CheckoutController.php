<?php

namespace App\Http\Controllers\Front;

use App\Exceptions\InvalidOrderException;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Services\CheckoutService;
use Illuminate\Support\Facades\Request;
use Symfony\Component\Intl\Countries;

class CheckoutController extends Controller
{
    public function __construct(
        protected CheckoutService $checkoutService
    ) {}
    public function create(Cart $cart)
    {
        if ($cart->get()->count() == 0) {
            throw new InvalidOrderException('cart is Empty');
        }
        return view('front.checkout', [
            'cart' => $cart,
            'count' => $cart->count(),
            'countries' => Countries::getNames(),
        ]);
    }
    public function store(Request $request)
    {
        return redirect()->route('orders.payment.create',$request->post('order_id'));
    }
}

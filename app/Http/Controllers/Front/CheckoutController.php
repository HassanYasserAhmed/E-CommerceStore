<?php

namespace App\Http\Controllers\Front;

use App\Exceptions\InvalidOrderException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\StoreCheckoutRequest;
use App\Models\Cart;
use App\Repositories\Cart\CartRepository;
use App\Repositories\Checkout\CheckoutRepository;
use Symfony\Component\Intl\Countries;

class CheckoutController extends Controller
{
    public function __construct(
        protected CheckoutRepository $checkoutRepository
    ){}
    public function create(CartRepository $cart)
    {
        if ($cart->get()->count() == 0) {
            throw new InvalidOrderException('cart is Empty');
        }

        return view('front.checkout', [
            'cart' => $cart,
            'countries' => Countries::getNames(),
        ]);
    }

    public function store(StoreCheckoutRequest $request, Cart $cart)
    {
        // dd($request->alll(),$request->validated());
       $data= $request->validated();

      $order= $this->checkoutRepository->Store($data,$cart);
     return redirect()->route('orders.payment.create', $order->id);
    }
}

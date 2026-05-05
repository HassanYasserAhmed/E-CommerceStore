<?php

namespace App\Http\Controllers\Front;

use App\Exceptions\InvalidOrderException;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Repositories\Cart\CartRepository;
use CheckoutRepository;
use Illuminate\Http\Request;
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

    public function store(Request $request, Cart $cart)
    {
       $data= $request->validated();

       $this->checkoutRepository->Store($data,$cart);
    }
}

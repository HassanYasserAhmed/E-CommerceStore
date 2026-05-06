<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Repositories\Cart\CartRepository;
use App\Repositories\Product\ProductRepository;

class HomeController extends Controller
{
    public function __construct(protected ProductRepository $productRepository
    ,protected CartRepository $cartRepository){}
    public function index()
    {
        $products = $this->productRepository->getActiveProducts();
        $cart_count = $this->cartRepository->count();
        return view('front.home', compact('products','cart_count'));

    }
    public function contact()
    {
        return view('front.contact');
    }
    public function AboutUs() {
        return view('front.about-us');
    }
    public function HaventFountTheAnswer() {
        return view('front.faq');
    }
}

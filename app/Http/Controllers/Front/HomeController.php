<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\product;
use App\Repositories\Product\ProductRepository;

class HomeController extends Controller
{
    public function __construct(protected ProductRepository $productRepository){}
    public function index()
    {
        $products = $this->productRepository->getActiveProducts();
        return view('front.home', compact('products'));

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

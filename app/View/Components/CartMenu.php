<?php

namespace App\View\Components;

use App\Models\Cart;
use App\Repositories\Cart\CartRepository;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CartMenu extends Component
{
    /**
     * Create a new component instance.
     */
    public $items;

    public $total;
    public $count;

    public function __construct(protected Cart $cart)
    {
        $this->items = $cart->get();
        $this->count= $cart->count();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.cart-menu');
    }
}

<?php

namespace App\Repositories\Cart;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class CartModelRepository implements CartRepository
{
    protected $items;

    public function __construct()
    {
        $this->items = collect([]);
    }

    public function get(): Collection
    {
        if (! $this->items->count()) {
            $this->items = Cart::with('product')->get();
        }

        return $this->items;
    }

    public function add($id, $quantity = 1)
    {
        $product = Product::findOrFail($id);

        $item = Cart::where('product_id', $product->id)->first();
        
        if (! $item) {
            $cart = Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);

            $this->items->push($cart);

            return;
        }

        return $item->increment('quantity', $quantity);
    }


    public function update($id, $quantity)
    {
        Cart::where('id', $id)
            ->update([
                'quantity' => $quantity,
            ]);
    }

    public function delete($id)
    {
        Cart::where('id', '=', $id)
            ->delete();
    }

    public function empty()
    {
        Cart::query()->delete();
    }

    public function total(): float
    {
        // return (float) Cart::join('products','products.id','=','carts.product_id')
        //     ->selectRaw('SUM(products.price * carts.quantity) as total')
        //     ->value('total') ?? 0;

        return (float) $this->items->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });
    }
}

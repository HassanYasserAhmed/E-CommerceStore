<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Repositories\Cart\CartRepository;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct(protected CartRepository $repo)
    {
    }

    public function index(Cart $cart)
    {
        return view('front.cart', [
            'cart' => $cart,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'int', 'exists:products,id'],
            'quantity' => ['nullable', 'int', 'min:1'],
        ]);

        $product = Product::findOrFail($request->post('product_id'));
        $this->repo->add($product, $request->post('quantity'));

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'item added to cart',
            ], 201);
        }

        return redirect()->route('cart.index')->with('success', 'product added to cart');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => ['required', 'int', 'min:1'],
        ]);
        $this->repo->update($id, $request->post('quantity'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
       $this->repo->delete($id);

        return [
            'message' => 'item deleted successfully',
        ];
    }
}

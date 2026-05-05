<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\StoreCartRequest;
use App\Models\Cart;
use App\Repositories\Cart\CartRepository;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct(protected CartRepository $cartepository)
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
    public function store(StoreCartRequest $request)
    {
        $request->validateed();
        
        $product_id=$request->post('product_id');

        $this->cartepository->add($product_id, $request->post('quantity'));

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
        $this->cartepository->update($id, $request->post('quantity'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
       $this->cartepository->delete($id);

        return [
            'message' => 'item deleted successfully',
        ];
    }
}

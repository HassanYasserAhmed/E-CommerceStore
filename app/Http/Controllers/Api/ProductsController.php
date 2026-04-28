<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(product::class, 'product');
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        return Product::filter($request->query())->with('category', 'store')->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', product::class);

        if (! $request->user()->tokenCan('product.create')) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 403);
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'status' => 'in:active,inactive',
            'price' => 'required|numeric |min:0',
            'compare_price' => 'nullable|numeric|gt:price',
        ]);
        $Product = Product::create($request->all());

        return $Product;
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return $product->load('category', 'store', 'tags');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $this->authorize('update', $product);

        if (! $request->user()->tokenCan('product.update')) {
            abort(403, 'Unauthorized');
        }
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'status' => 'in:active,inactive',
            'price' => 'required|numeric |min:0',
            'compare_price' => 'nullable|numeric|gt:price',
        ]);
        $product->update($request->all());

        return $product;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->authorize('delete', product::class);

        if (! Auth::user()->tokenCan('product.delete')) {
            abort(403, 'Unauthorized');
        }
        $product = Product::destroy(19);

        return response()->json([
            'message' => 'Product deleted successfully',
            'product' => $product,
        ], 200);
    }
}

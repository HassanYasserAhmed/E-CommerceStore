<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Product::filter($request->query())->with('category','store')->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|string|max:255',
            'description'=>'nullable|string|max:255',
            'category_id'=>'required|exists:categories,id',
            'status'=>'in:active,inactive',
            'price'=>'required|numeric |min:0',
            'compare_price'=>'nullable|numeric|gt:price',
        ]);        
        $Product=Product::create($request->all());
        return $Product;
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Product $product)
    {
         $request->validate([
            'name'=>'sometimes|required|string|max:255',
            'description'=>'nullable|string|max:255',
            'category_id'=>'required|exists:categories,id',
            'status'=>'in:active,inactive',
            'price'=>'required|numeric |min:0',
            'compare_price'=>'nullable|numeric|gt:price',
        ]);        
        $product->update($request->all());
        return $product;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Product::destroy($id);
        return response()->json(null,204);
    }
}

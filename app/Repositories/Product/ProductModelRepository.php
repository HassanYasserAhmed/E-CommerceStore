<?php

namespace App\Repositories\Product;

use App\Models\category;
use App\Models\Product;
use Illuminate\Support\Facades\Request;

class ProductModeleRepository implements ProductRepository
{
    public function all()
    {
        return Product::all();
    }

    public function find($id)
    {
        return Product::findOrFail($id);
    }
    public function findWithRelationsById($id, array $relations)
    {
        return Product::with($relations)->findOrFail($id);
    }

    public function findModelWithRelations(Product $product, array $relations)
    {
        return $product->load($relations);
    }
    public function getProductsForApi(Request $request)
    {
        return Product::filter($request->query())->with('category', 'store')->paginate(10);
    }
    public function store(array $data)
    {
        return Product::create($data);
    }
    public function update(Product $product, array $data)
    {
        return $product->update($data);
    }
    public function deleteByID($id)
    {
        return Product::destroy($id);
    }
    public function getProductsWithRelations(array $relations)
    {
        return Product::with($relations)->paginate(10);
    }
        public function getCreateFormData()
    {
        return [
            'product' => new Product(),
            'categories' => category::all(),
        ];
    }
    public function getProductsForDashboard()
     {
         return $this->getProductsWithRelations(['category', 'store']);
     }
     public function getActiveProducts() {
       return Product::with('category')->active()
            ->latest()
            ->limit(8)
            ->get();
     }
}

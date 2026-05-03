<?php
namespace App\Repositories\Product;
use App\Models\Product;
use Illuminate\Support\Facades\Request;

class ProductModeleRepository implements ProductRepository {
    public function all()
    {
        return Product::all();
    }

    public function find($id)
    {
        return Product::findOrFail($id);
    }
    public function findModel(Product $product)
    {
        return $product;
    }
     public function findWithRelationsById($id, array $relations)
    {
        return Product::with($relations)->findOrFail($id);
    }

    public function findModelWithRelations(Product $product, array $relations)
    {
        return $product->load($relations);
    }
    public function getProductsFroApi(Request $request) {
            return Product::filter($request->query())->with('category', 'store')->paginate(10);
    }
    public function create(array $data)
    {
        return Product::create($data);
    }
    public function update(Product $product, array $data) {
         return $product->update($data);
    }
    public function deleteByID($id)
    {
        return Product::destroy($id);
    }
}
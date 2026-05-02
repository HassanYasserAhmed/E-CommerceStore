<?php
namespace App\Repositories\Product;
use App\Models\Product;
class ProductModeleRepository implements ProductRepository {
    public function all()
    {
        return Product::all();
    }

    public function find($id)
    {
        return Product::findOrFail($id);
    }
}
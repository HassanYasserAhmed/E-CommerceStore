<?php
namespace App\Repositories\Product;

use App\Models\Product;
use Illuminate\Support\Facades\Request;

interface ProductRepository
{
    public function all();

    public function find($id);
    public function findModel(Product $product);
    public function findWithRelationsById($id, array $relations);
    public function findModelWithRelations(Product $product, array $relations);
    public function getProductsFroApi(Request $request);
    public function create(array $data);
    public function update(Product $product, array $data);
    public function deleteByID($id);
}
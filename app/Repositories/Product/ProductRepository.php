<?php
namespace App\Repositories\Product;

use App\Models\Product;
use Illuminate\Support\Facades\Request;

interface ProductRepository
{
    public function all();
    public function find($id);
    public function findWithRelationsById($id, array $relations);
    public function findModelWithRelations(Product $product, array $relations);
    public function getProductsForApi(Request $request);
    public function store(array $data);
    public function update(Product $product, array $data);
    public function deleteByID($id);
    public function getProductsWithRelations(array $relations);
    public function getCreateFormData();
    public function getProductsForDashboard();
    public function getActiveProducts();
}
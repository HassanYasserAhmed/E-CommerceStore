<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\Product\ProductRepository;
use Illuminate\Support\Facades\Request;

class ProductService
{
    public function __construct(
        protected ProductRepository $productRepository
    ) {}
    public function getProductsForApi(Request $request)
    {
        return $this->productRepository->getProductsFroApi($request);
    }
    public function create(array $data)
    {
        return $this->productRepository->create($data);
    }
    public function showModel(Product $product)
    {
        return $this->productRepository->findModelWithRelations($product, ['category', 'store', 'tags']);
    }
    public function update(Product $product, array $data)
    {
        return $this->productRepository->update($product, $data);
    }
    public function deleteByID($id)
    {
        return $this->productRepository->deleteByID($id);
    }
}

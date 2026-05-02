<?php
namespace App\Repositories\Product;
interface ProductRepository
{
    public function all();

    public function find($id);
}
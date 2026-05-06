<?php

namespace App\Repositories\Cart;

use App\Models\product;
use Illuminate\Support\Collection;

interface CartRepository
{
    public function get(): Collection;

    public function add($id
    , $quantity = 1);

    public function update($id, $quantity);

    public function delete(Product $product);

    public function empty();

    public function total(): float;
    public function count();
}

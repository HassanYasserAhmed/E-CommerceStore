<?php

namespace App\Repositories\Product;

use App\Models\category;
use App\Models\Flag;
use App\Models\Product;
use App\Models\Tag;
use Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Str;

class ProductModelRepository implements ProductRepository
{
    public function all()
    {
        return Product::all();
    }
    public function find($id)
    {
        return Product::with('flags')->findOrFail($id);
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
        return DB::transaction(function () use ($data) {
            $product = Product::create($data);
            $flags = $data['flags'] ?? [];

            $product->flags()->sync($flags);
            return $product->fresh();
        });
    }

    public function update(Product $product, array $data)
    {
        return DB::transaction(function () use ($product, $data) {
            $product->update($data);
            $flags = $data['flags'] ?? [];

            $product->flags()->sync($flags);

            return $product->fresh();
        });
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
            'tags' => '',
            'flags' => Flag::all(),
        ];
    }
    public function getProductsForDashboard()
    {
        return $this->getProductsWithRelations(['category', 'store']);
    }

    public function getActiveProducts()
    {
        return Product::with('category')->active()
            ->latest()
            ->limit(8)
            ->get();
    }

    public function resolveTags(string $tags): array
    {
        $tagIds = [];

        $tags = array_filter(explode(',', $tags));

        foreach ($tags as $name) {
            $slug = Str::slug($name);

            $tag = Tag::firstOrCreate(
                ['slug' => $slug],
                ['name' => $name]
            );

            $tagIds[] = $tag->id;
        }

        return $tagIds;
    }

    public function updateWithTags(int $id, array $data): Product
    {
        return DB::transaction(function () use ($id, $data) {
            $product = $this->find($id);
            $this->update(
                $product,
                Arr::except($data, 'tags')
            );
            $tagIds = $this->resolveTags($data['tags'] ?? '');

            $product->tags()->sync($tagIds);

            return $product->fresh();
        });
    }
}

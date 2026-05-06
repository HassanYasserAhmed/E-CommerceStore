<?php
namespace App\Repositories\Tag;
use App\Models\Tag;

class TagModelRepository implements TagRepository {
     public function firstOrCreate(string $name, string $slug): Tag
    {
        return Tag::firstOrCreate(
            ['slug' => $slug],
            ['name' => $name]
        );
    }
}
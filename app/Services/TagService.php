<?php
namespace App\Services;

use App\Repositories\Tag\TagRepository;
use Str;

class TagService {
     public function __construct(
        protected TagRepository $tagRepository
    ) {}

      public function resolveTags(string $tags): array
    {
        $tagIds = [];

        $tags = array_filter(explode(',', $tags));

        foreach ($tags as $name) {
            $slug = Str::slug($name);

            $tag = $this->tagRepository->firstOrCreate($name, $slug);

            $tagIds[] = $tag->id;
        }

        return $tagIds;
    }
}
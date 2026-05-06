<?php
namespace App\Repositories\Tag;

interface TagRepository
{
    public function firstOrCreate(string $name, string $slug);
}
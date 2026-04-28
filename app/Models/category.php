<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class category extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'name', 'parent_id', 'description', 'image', 'status', 'slug',
    ];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id')->withDefault([
            'name' => '-',
        ]);
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function products()
    {
        return $this->hasMany(product::class);
    }

    public function scopeActive(Builder $query)
    {
        return $query->where('status', '=', 'active');
    }

    public function scopeStatus(Builder $query, $status)
    {
        return $query->whereStatus($status);
    }

    public function scopeFilter(Builder $builder, $filter)
    {

        $builder->when($filter['name'] ?? false, function ($builder, $value) {
            $builder->where('categories.name', 'LIKE', "%$value%");
        });

        $builder->when($filter['status'] ?? false, function ($builder, $value) {
            $builder->where('categories.status', '=', $value);
        });
    }
}

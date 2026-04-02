<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\StoreScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
class product extends Model
{

    use HasFactory;
    protected $hidden = ['created_at','updated_at','deleted_at','image'];
    protected $appends = ['image_url'];
       protected $fillable = [
    'name', 'slug', 'description', 'image', 'category_id', 'store_id',
    'price', 'compare_price', 'status','quantity'
];
    public function Category() {
        return $this->belongsTo(Category::class)->withDefault([
            'name'=>"-"
        ]);
    }
    public function store() {
        return $this->belongsTo(store::class);
    }
    public function tags() {
        return  $this->belongsToMany(
            Tag::class,
            'product_tag',
            'product_id',
            'tag_id',
            'id',
            'id'
            );  
    }
    
    protected static function booted() {

        static::addGlobalScope('store',new StoreScope());

        static::creating(function(product $product) {
            $product->slug = Str::slug($product->name); 
        });
    }
    public function scopeActive(Builder $builder) {
        $builder->where('status','=','active');
    }
// Accessors
public function getImageUrlAttribute()
{
    if (!$this->image) {
        return 'https://www.incathlab.com/images/products/default_product.png';
    }

    if (Str::startsWith($this->image, ['http://', 'https://'])) {
        return $this->image;
    }

    return asset('storage/' . $this->image);
}

public function getSalePercentAttribute() {
    return number_format(100 - (100 * $this->price/$this->compare_price),1);
}

public function scopeFilter(Builder $builder,$filters) {
    $options = array_merge([
        'store_id'=>null,
        'category_id'=>null,
        'tag_id'=>null,
        'status'=>'active',
    ],$filters);

    $builder->when($options['status'],function($builder,$value) {
        $builder->where('status',$value);
    });
    
    $builder->when($options['store_id'],function($builder,$value) {
        $builder->where('store_id',$value);
    });

    $builder->when($options['category_id'],function($builder,$value) {
        $builder->where('category_id',$value);
    });

    $builder->when($options['tag_id'],function($builder,$value) {

    $builder->whereExists(function($query) use ($value) {

        $query->select('1')
            ->from('product_tag')
            ->whereRaw('product_tag.product_id  = products.id')
            ->where('tag_id',$value);
        });

    //    $builder->whereRaw('Exists (select 1 from product_tag where product_tag.product_id = products.id and product_tag.tag_id = ?',[$value]);
    });
}

}


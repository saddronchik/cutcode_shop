<?php

namespace App\Models;


use App\Traits\Models\HasSlug;
use App\Traits\Models\HasThumbnail;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    use HasSlug;
    use HasThumbnail;

    protected $fillable=[
        'slug',
        'title',
        'brand_id',
        'price',
        'thumbnail',
        'on_home_page',
        'sorting'
     ];

    protected function thumbnailDir(): string
    {
        return 'products';
    }

    public function scopeHomePage(Builder $query)
    {
        $query->where('on_home_page',true)
            ->orderBy('sorting')
            ->limit(6);
    }


     protected static function boot()
     {
        parent::boot();

        static::creating(function(Product $product){
            $product->slug = $product->slug ?? str($product->title)->slug;
        });

     }

     public function brand()
     {
        return $this->belongsTo(Brand::class);
     }

     public function categories(){
        return $this->belongsToMany(Category::class);
     }


}

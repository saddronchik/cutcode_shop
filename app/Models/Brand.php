<?php

namespace App\Models;

use App\Traits\Models\HasSlug;
use App\Traits\Models\HasThumbnail;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    use HasSlug;
    use HasThumbnail;

     protected $fillable=[
        'slug',
        'title',
        'thumbnail',
         'on_home_page',
         'sorting'
     ];

    protected function thumbnailDir(): string
    {
        return 'brands';
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

        static::creating(function(Brand $brand){
            $brand->slug = $brand->slug ?? str($brand->title)->slug;
        });

     }

     public function products()
     {
        return $this->hasMany(Product::class);
     }
}

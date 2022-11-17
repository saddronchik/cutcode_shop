<?php

namespace Domain\Catalog\Models;

use App\Models\Product;
use Domain\Catalog\Collections\BrandCollection;
use Domain\Catalog\QueryBuilders\BrandQueryBuilder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Support\Traits\Models\HasSlug;
use Support\Traits\Models\HasThumbnail;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @method static Brand|BrandQueryBuilder query()
 */
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

//     public function scopeHomePage(Builder $query)
//     {
//        $query->where('on_home_page',true)
//            ->orderBy('sorting')
//            ->limit(6);
//     }


    public function newCollection(array $models = []): BrandCollection
    {
        return new BrandCollection($models);
    }

    public function newEloquentBuilder($query): BrandQueryBuilder
    {
        return new BrandQueryBuilder($query);
    }

    protected static function boot()
     {
        parent::boot();

        static::creating(function(Brand $brand){
            $brand->slug = $brand->slug ?? str($brand->title)->slug;
        });

     }

     public function products(): HasMany
     {
        return $this->hasMany(Product::class);
     }
}

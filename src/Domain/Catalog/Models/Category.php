<?php

namespace Domain\Catalog\Models;

use App\Models\Product;
use Database\Factories\BrandFactory;
use Domain\Catalog\Collections\CategoryCollection;
use Domain\Catalog\QueryBuilders\BrandQueryBuilder;
use Domain\Catalog\QueryBuilders\CategoryQueryBuilder;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


/**
 * @method static Category|BrandQueryBuilder query()
 */
class Category extends Model
{
    use HasFactory;

    protected $fillable=[
        'slug',
        'title',
        'on_home_page',
        'sorting'
     ];
//    public function scopeHomePage(Builder $query)
//    {
//        $query->where('on_home_page',true)
//            ->orderBy('sorting')
//            ->limit(6);
//    }
    public function newCollection(array $models = []): CategoryCollection
    {
        return new CategoryCollection($models);
    }

    public function newEloquentBuilder($query): CategoryQueryBuilder
    {
        return new CategoryQueryBuilder($query);
    }

    protected static function boot()
     {
        parent::boot();

        static::creating(function(Category $category){
            $category->slug = $category->slug ?? str($category->title)->slug;
        });

     }

     public function products(): BelongsToMany
     {
        return $this->belongsToMany(Product::class);
     }

//     protected static function newFactory()
//     {
//         return BrandFactory::new();
//     }
}

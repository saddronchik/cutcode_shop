<?php

namespace App\Models;


use App\Jobs\ProductJsonProperties;
use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Pipeline\Pipeline;
use Laravel\Scout\Attributes\SearchUsingFullText;
use Laravel\Scout\Attributes\SearchUsingPrefix;
use Laravel\Scout\Searchable;
use Support\Casts\PriceCast;
use Support\Traits\Models\HasSlug;
use Support\Traits\Models\HasThumbnail;
//use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    use HasSlug;
    use HasThumbnail;
//    use Searchable;

    protected $fillable=[
        'slug',
        'title',
        'brand_id',
        'price',
        'thumbnail',
        'on_home_page',
        'sorting',
        'text',
        'json_properties'
     ];

    protected $casts = [
      'price'=>PriceCast::class,
        'json_properties'=>'array'
    ];


    protected static function boot()
    {
        parent::boot();

       static::created(function (Product $product){
        ProductJsonProperties::dispatch($product)
        ->delay(now()->addSeconds(10));
       });



    }

    private mixed $optionValues;

    protected function thumbnailDir(): string
    {
        return 'products';
    }

//    #[SearchUsingPrefix(['id'])]
//    #[SearchUsingFullText(['title','text'])]
//    public function toSearchableArray(): array
//    {
//        return [
//            'id' => $this->id,
//            'title' => $this->title,
//            'text' => $this->text,
//        ];
//    }


//    public function scopeSorted(Builder $query)
//    {
//        sorter()->run($query);
//    }

    public function scopeFiltered(Builder $query)
    {
        return app(Pipeline::class)
            ->send($query)
            ->through(filters())
            ->thenReturn();

//        foreach (filters() as $filter){
//            $query= $filter->apply($query);
//        }

//        $query->when(request('filters.brands'),function (Builder $q){
//            $q->whereIn('brand_id', request('filters.brands'));
//        })
//            ->when(request('filters.price'),function (Builder $q){
//                $q->whereBetween('price',[
//                    request('filters.price.from',0)*100,
//                    request('filters.price.to',10000)*100,
//                ]);
//        });
    }

    public function scopeSorted(Builder $query)
    {
        $query->when(request('sort'),function (Builder $q){
            $column = request()->str('sort');

            if ($column->contains(['price','title'])){
                $direction = $column->contains('-') ? 'DESC' : 'ASC';

                $q->orderBy((string)$column->remove('-'),$direction);
            }
        });
    }

    public function scopeHomePage(Builder $query)
    {
        $query->where('on_home_page',true)
            ->orderBy('sorting')
            ->limit(6);
    }



     public function brand(): BelongsTo
     {
        return $this->belongsTo(Brand::class);
     }

     public function categories(): BelongsToMany
     {
        return $this->belongsToMany(Category::class);
     }

     public function properties():BelongsToMany
     {
        return $this->belongsToMany(Property::class)
            //нужен для связии получение данных value не обращаясь к связной таблице
            ->withPivot('value');
     }

     public function optionValues(): BelongsToMany
     {
         return $this->belongsToMany(OptionValue::class);
     }


}

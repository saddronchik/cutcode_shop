<?php

namespace App\Models;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable=[
        'slug',
        'title',
        'on_home_page',
        'sorting'
     ];

    public function scopeHomePage(Builder $query)
    {
        $query->where('on_home_page',true)
            ->orderBy('sorting')
            ->limit(6);
    }

     protected static function boot()
     {
        parent::boot();

        static::creating(function(Category $category){
            $category->slug = $category->slug ?? str($category->title)->slug;
        });

     }

     public function products(){
        return $this->belongsToMany(Product::class);
     }
}

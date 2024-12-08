<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia, Sluggable;	

    protected $fillable = [
        'name',
        'description',
        'status',
        'visibility',
        'category_id',
        'additional_info',
        'display_price',
        'has_multiple_options'
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Product Model
   /* public function media()
    {
        return $this->hasMany(Media::class); 
    } */

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('product_image')->singleFile(); // Single file for product image
        $this->addMediaCollection('product_gallery'); // Multiple files for product gallery
    }
 
   /* public function meta()
    {
        return $this->hasOne(ProductMeta::class);
    }    

    public function collection()
    {
        return $this->belongsToMany(Collection::class);
    }  */

    
}

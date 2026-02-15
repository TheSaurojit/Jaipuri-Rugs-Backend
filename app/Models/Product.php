<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id', 'title', 'description',  'meta_keywords', 'price', 'quantity', 'is_active', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function multipleImages()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function singleImage()
    {
        return $this->hasOne(ProductImage::class);
    }

    public function collections()
    {
        return $this->belongsToMany(ProductCollection::class, 'product_collection_product');
    }

    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }
}

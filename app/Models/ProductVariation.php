<?php

namespace App\Models;

use App\Models\Shape;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    //
    protected $fillable = [
        'product_id',
        'shape_id',
        'size',
        'price',
    ];

    public function shape()
    {
        return $this->belongsTo(Shape::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

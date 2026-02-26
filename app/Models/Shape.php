<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shape extends Model
{
    protected $fillable = ['name'];

    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }
}

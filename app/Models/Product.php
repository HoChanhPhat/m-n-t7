<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

   protected $fillable = [
    'name',
    'description',
    'price',
    'quantity',
    'image',
    'category_id',
    'brand_id',
    'specs',
];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    protected $casts = [
    'specs' => 'array',
];


public function reviews()
{
    return $this->hasMany(Review::class);
}

public function avgRating()
{
    return $this->reviews()->avg('rating');
}
public function images()
{
    return $this->hasMany(\App\Models\ProductImage::class);
}

}


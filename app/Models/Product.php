<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
       'title',
       'slug',
       'image',
       'summary',
       'description',
       'stock',
       'brand_id',
       'category_id',
       'vendor_id',
       'category_child_id',
       'price',
       'offer_price',
       'discount',
       'size',
       'condition',
       'status',
    ];

    public function brand(){
        return $this->belongsTo(Brand::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }


    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

}

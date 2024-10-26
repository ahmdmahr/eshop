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
       'additional_info',
       'return_and_cancellation',
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

    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function orders() {
        return $this->belongsTo(Order::class);
    }

    public function related_products(){
        // this go and see the products that has the current product categroy_id and get all of them then exclude the current product record.
        return $this->hasMany(Product::class,'category_id')->where('id', '!=', $this->id)->where('status','active')->limit(10);
    }

}

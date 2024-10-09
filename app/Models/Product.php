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
       'summary',
       'description',
       'stock',
       'brand_id',
       'category_id',
       'vendor_id',
       'category_child_id',
       'photo',
       'price',
       'offer_price',
       'discount',
       'size',
       'condition',
       'status',
    ];
}

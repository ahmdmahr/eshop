<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'subtotal',
        'total',
        'coupon',
        'payment_method',
        'payment_status',
        'condition',
        'delivery_charge',
        'notes'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function products() {
        return $this->hasMany(Product::class);
    }

    public function order_items(){
        return $this->hasMany(OrderItem::class);
    }

}

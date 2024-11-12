<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'meta_description',
        'meta_keywords',
        'logo',
        'favicon',
        'email',
        'phone',
        'address',
        'fax',
        'footer',
        'facebook',
        'twitter',
        'linkedin',
        'pinterest',
        'paypal_sandbox'
    ];
}

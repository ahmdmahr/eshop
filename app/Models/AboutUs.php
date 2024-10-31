<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    use HasFactory;

    protected $fillable = [
        'heading',
        'content',
        'image1',
        'image2',
        'image3',
        'image4',
        'years_of_experience',
        'happy_customers',
        'parteners',
        'growth'
    ];
}

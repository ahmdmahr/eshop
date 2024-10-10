<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'slug',
        'summary',
        'photo',
        'is_parent',
        'parent_id',
        'status'
    ];
    public static function shiftChild($category_id){
        Category::where('id',$category_id)->update(['is_parent'=>1]);
    }

    public static function getChildByParentID($id){
        // make an array of id as key and title as value [id1=>title1,id2=>title2]
        return Category::where('parent_id',$id)->pluck('title','id');
    }

    public function products(){
        return $this->hasMany(Product::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Product;
use App\Models\Sector;


class Section extends Model
{
    protected $fillable=['Section_type','category_id','Section_image'];
    use HasFactory;


    public function category(){
        
        return $this->belongsTo(Category::class);
    }

    public function getProducts(){
        return $this->hasMany(Product::class);
    }

    public function sectors()
    {
        return $this->hasMany(Sector::class);
    }
}

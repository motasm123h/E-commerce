<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Section;
use App\Models\Product;

class Category extends Model
{
    protected $fillable=['type'];
    use HasFactory;

    public function sections()
    {
        return $this->hasMany(Section::class);    
    }
    public function products(){
        return $this->hasMany(Product::class);
    }
}

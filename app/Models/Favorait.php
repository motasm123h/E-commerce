<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Favorait extends Model
{
    protected $fillable = ['user_id','product_id'];
    use HasFactory;

    public function products()
    {
        return $this->belongsToMany(Product::class, 'favoraits', 'user_id', 'product_id');
    }
}

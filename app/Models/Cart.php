<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cart;
use App\Models\Product;


class Cart extends Model
{
    protected $fillable =[
        'user_id','product_id','image','name',
        'Quntity','Unit_Price_After_Discount','Unit_Price_Without_Discount',
        'Brand',
    ];
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }
}

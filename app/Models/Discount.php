<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Product;


class Discount extends Model
{

    protected $fillable = [
        'product_id',
        'percentage_off',
        'start_date',
        'end_date',
    ];
    use HasFactory;

    public function products(){
        return $this->belongsTo(Product::class);
    }
}

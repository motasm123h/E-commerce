<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
class Laptop extends Model
{
    protected $fillable = ['LapTop_Type','product_id'];
    use HasFactory;

    public function product(){
        return $this->belongsTo(Product::class);
    }
}

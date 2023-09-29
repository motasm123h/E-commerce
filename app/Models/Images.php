<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Images extends Model
{
    protected $fillable = ['product_id','name'];
    use HasFactory;

    public function Images(){
        return $this->belongsTo(Product::class);
    }

}

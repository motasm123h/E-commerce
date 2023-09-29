<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Section;
use App\Models\Product;

class Sector extends Model
{
    protected $fillable = [
        'section_id',
        'name',
    ];
    use HasFactory;

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function getProducts(){
        return $this->hasMany(Product::class);
    }
}

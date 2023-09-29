<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Monitordetails extends Model
{
    protected $fillable =[
        'product_id',
        'Display_Size',
        'Displa_Technology',
        'Display_Resolution',
        'Contrast_Ratio',
        'Response_Time',
        'Signal_Frequency',
        'Multimedia_Speakers',
        'Ports',
        'Warranty',
    ];
    use HasFactory;

    public function montior(){
       return  $this->belongsTo(Product::class);
    }
}

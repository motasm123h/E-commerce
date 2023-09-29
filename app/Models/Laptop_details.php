<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;


class Laptop_details extends Model
{
    protected $fillable = [
        'product_id',
        'Processor_Generation',
        'Processor_Family',
        'Processor_Speed',
        'Processor_Cash',
        'Number_Of_Coures',
        'Ram_Capacity',
        'Memory_Type',
        'Storage_Capacity',
        'Storage_Type',
        'Graphic_Manufacturer',
        'Graphic_Model',
        'Graphic_Memory_Source',
        'Display_Size',
        'Displa_Technology',
        'Display_Resolution',
        'Keyboard',
        'Keyboard_Backlight',
        'Ports',
        'Optical_Drive',
        'Camera',
        'Audio',
        'Networking',
        'Battery_Number_Of_Cells',
        'Operation_System',
        'multiMedia',
        'Case_Model',
        'Light_Type',
        'Power_Supply',
        'Warranty',
    ];
    use HasFactory;


    public function laptop(){
        return $this->belongsTo(Product::class);
    }
}

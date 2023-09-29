<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class storagedetailes extends Model
{
    protected $fillable = [
        'product_id','Disk_Technology','Disk_Size',
        'Disk_Capacity','Disk_Speed','Disk_Cache',
        'Disk_Interface','Best_Used_For','Flash_Capacity',
        'Flash_Type','Interface','Compatible_with',
        'Warranty',
    ];
    use HasFactory;

    public function sotrageDetails(){
       return  $this->belongsTo(Product::class);
    }
}

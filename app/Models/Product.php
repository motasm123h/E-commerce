<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Laptop_details;
use App\Models\Discount;
use App\Models\Laptop;
use App\Models\Section;
use App\Models\Sector;
use App\Models\Monitordetails;
use App\Models\storagedetailes;
use App\Models\User;
use App\Models\Images;


class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'section_id','sector_id','category_id',
        'Type','price','name',
        'image','Availabilty','Quntity',
        'product_code','Brand','desc'
    ];

    protected $casts = [
    //  'other_images' => 'array',
    ];


    public function Details(){
        return $this->hasMany(Laptop_details::class);
    }
    public function MonitorDetails(){
        return $this->hasMany(Monitordetails::class);
    }
    public function StorageDetails(){
        return $this->hasMany(storagedetailes::class);
    }


    
    public function discounts(){
        return $this->hasMany(Discount::class);
    }


    public function laptops(){
        return $this->hasMany(Laptop::class);
    }



    public function section(){
        return $this->belongsTo(Section::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function sector(){
        return $this->belongsTo(Sector::class);
    }

    public function images(){
        return $this->hasMany(Images::class);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favoraits', 'product_id', 'user_id');
    }

    public function carts()
    {
        return $this->belongsToMany(Cart::class)->withPivot('quantity');
    }


    public static  function getNewProduct($query){
        return $query->where('type','NEW')
            ->select('name','price','image','id','Brand');
    }
   
    public static  function getUsedProduct($query){
        return $query->where('type','USED')
            ->select('name','price','image','id','Brand');
    }

    public static function getDiscontinuedProduct($query){
        return $query->with('discounts')
            ->select('name','price','image','id','Brand')
            ->has('discounts');
    }

    public static function getProductByhereSection($query ,$section_id){
        return $query->where('section_id',$section_id)
                ->with(['discounts' => function ($query) {
                $query->select('id', 'percentage_off', 'product_id');
                }])
                ->select('name','price','image','id','Brand');
    }
    public static function getProductBySector($query ,$sector_id){
        return $query->where('sector_id',$sector_id)
                ->with(['discounts' => function ($query) {
                $query->select('id', 'percentage_off', 'product_id');
                }])
                ->select('name','price','image','id','Brand');
    }
   
}

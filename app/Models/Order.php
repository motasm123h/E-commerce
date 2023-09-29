<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Order extends Model
{
    protected $fillable=[
        'name','user_id','email',
        'phone_number','shipping_address','total_amount',
        'products','status','products','location'
    ];
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);
    }
}

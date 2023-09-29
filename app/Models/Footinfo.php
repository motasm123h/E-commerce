<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Footinfo extends Model
{
    protected $fillable = [
        'email','address','numberOne','numberTwo','numberThree',
        'description','faceBook_Account','instagram_Account',
        'twitter_Account',
    ];
    use HasFactory;

}

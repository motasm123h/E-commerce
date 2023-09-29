<?php

namespace App\Http\Controllers;
use App\Models\Product;

use Illuminate\Http\Request;

class SearchController extends Controller
{

        public function __construct()
    {
        $this->query = Product::query();
    }

    function applyDiscountLogic($product) {
        if (isset($product->discounts[0])) {
            $discountedPrice = $product->price - (($product->price * $product->discounts[0]->percentage_off) / 100);
            $product->final_price = round($discountedPrice, 2);
            $product->percentage_off = $product->discounts[0]->percentage_off;
            $product->discount_id = $product->discounts[0]->id;
        } else {
            $product->final_price = round($product->price, 2);
        }
    }
    
    function unsetDiscount($product)
    {
        unset($product->discounts);
    }

    public function index($req){
        $products = Product::where('name','like', '%'.$req.'%')
        ->orWhere('desc','like', '%'.$req.'%')
        ->orWhere('Brand','like', '%'.$req.'%')
        ->select('name','price','image','id','Brand')
        ->with('discounts')
        ->get();

        foreach($products as $product) 
            {
                $this->applyDiscountLogic($product);
        
            }
        foreach($products as $product) 
        {
            $this->unsetDiscount($product);
        }

        return response()->json([
            'result' => $products
        ]);
    }
}

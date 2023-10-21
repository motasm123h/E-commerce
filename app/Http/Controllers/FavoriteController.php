<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorait;
use App\Models\Product;
use App\Models\User;

class FavoriteController extends Controller
{
    public function makeOrDeleteFavorites($product_id){
        $product = Product::where('id',$product_id)->first();
        
        if(!$product) {
            return response()->json([
                'message' => 'product not found',
            ]);
        }

        $fav = Favorait::where([
            'user_id'=>auth()->user()->id,
            'product_id' =>$product_id
        ])->first();

        if(!$fav) {
            $favorite = Favorait::create([
                'user_id' => auth()->user()->id,
                'product_id' => $product_id
            ]);
        return response()->json([
            'favorite' =>$favorite
        ]);
        }
        
        return response()->json([
            'message' => $fav->delete(),
        ]);
        
        

    }

    public function getFavProduct(){
        $user = User::where('id',auth()->user()->id)->first();
        $products = $user->favorites()->select('products.id', 'products.name','products.Brand', 'products.price', 'products.image')->with('discounts')->get();


        foreach ($products as $product)
        {
            if (isset($product->discounts[0])) {
                $discountedPrice = $product->price - (($product->price * $product->discounts[0]->percentage_off) / 100);
                $product->final_price = round($discountedPrice, 2);
                $product->percentage_off = $product->discounts[0]->percentage_off;
                $product->discount_id = $product->discounts[0]->id;
            } else {
                $product->final_price = round($product->price, 2);
            }
        }
        foreach($products as $product) 
        {
            unset($product->discounts);
        }
        foreach($products as $product){
            unset($product->pivot);
        }


        
        
        return response()->json([
            'message' => $products,
        ]);
    }
}

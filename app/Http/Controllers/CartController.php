<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;


class CartController extends Controller
{
    public function index(){
        $cartItem = auth()->user()->carts()->get();
        return response()->json([
            'cartItem' => $cartItem,
        ]);
    }

    public function addItemToCart(Request $request){
        $validatedData = $request->validate([
            'Quntity' => 'required|integer',
            'product_id' => 'required',
        ]);

        $product = Product::where('id', $validatedData['product_id'])->with(['discounts'])->first();
        $final_price;
       
        if(isset($product->discounts[0])){
                $discountedPrice = $product->price - (($product->price * $product->discounts[0]->percentage_off) / 100);   
                $final_price = round($discountedPrice, 2);
        } 
        else {
                $final_price = round($product->price, 2);
        }
        unset($product->discounts);
        

        
        $productQuantity = $validatedData['Quntity'];


        if ($productQuantity > $product->Quntity) {
            return response()->json(['error' => 'Product quantity exceeds the available limit.'], 400);
        }

        $existingCartItem = Cart::where([
            ['name', $product['name']],
            ['user_id', auth()->user()->id],
            ['product_id', $validatedData['product_id']],
        ])->first();

        if ($existingCartItem) {
            $existingCartItem->Quntity += $validatedData['Quntity'];
            $existingCartItem->save();

            $product->update([
            'Quntity' => $product->Quntity - $validatedData['Quntity'],
            ]); 

            return response()->json([
                'message' => 'Product quantity increased in the cart.',
                'cartItem' => $existingCartItem
            ]);
        }

        $cartItem = Cart::create([
            'image' => $product['image'],
            'name' => $product['name'],
            'Quntity' => $validatedData['Quntity'],
            'Unit_Price_After_Discount' => $final_price,
            'Unit_Price_Without_Discount' => $product['price'],
            'product_id' => $validatedData['product_id'],
            'Brand' => $product['Brand'],
            'user_id' => auth()->user()->id,
        ]);
        $product->update([
            'Quntity' => $product->Quntity - $validatedData['Quntity'],
        ]);
        $product->save();

        if($product->Quntity == 0){
                $product->Availabilty = 'Out of stock' ;
                $product->save();
        }

        return response()->json([
            'message' => 'Product added to cart.',
            'cartItem' => $cartItem
        ]);
    }

    public function deleteItemFromCart(Request $request){
      $validatedData = $request->validate([
        'cart_item_id' => 'required|integer',
        ]);
        
        $cartItem = Cart::where('id',$validatedData['cart_item_id'])->first();
        if (!$cartItem) {
            return response()->json(['error' => 'Cart item not found.'], 404);
        }

        if ($cartItem->user_id !== auth()->user()->id) {
            return response()->json(['error' => 'Unauthorized.'], 401);
        }
        $product = Product::find($cartItem->product_id);
        if ($product) {
            $product->Quntity += $cartItem->Quntity;
            if ($product->Quntity == 0) {
                $product->Availabilty = 'Out of stock';
            }
            else if ($product->Quntity > 0 ){
                $product->Availabilty = 'In stock';
            }
            $product->save();
        }
        $cartItem->delete();

        return response()->json(['message' => 'Cart item deleted successfully.']);
   
    }

    public function deleteOneItemFromCart(Request $request){
         $validatedData = $request->validate([
        'cart_item_id' => 'required|integer',
        ]);
        
        $cartItem = Cart::find($validatedData['cart_item_id']);
        if (!$cartItem) {
            return response()->json(['error' => 'Cart item not found.'], 404);
        }

        if ($cartItem->user_id !== auth()->user()->id) {
            return response()->json(['error' => 'Unauthorized.'], 401);
        }
        $product = Product::find($cartItem->product_id);
        if ($product) {
            $product->Quntity += 1;
            if ($product->Quntity == 0) {
                $product->Availabilty = 'Out of stock';
            }
            else if ($product->Quntity > 0 ){
                $product->Availabilty = 'In stock';
            }
            $product->save();
        }
        $cartItem->Quntity -= 1;
        $cartItem->save();
        if($cartItem->Quntity == 0) {
            $cartItem->delete();
            return response()->json([
                'message' => 'Cart item deleted successfully.'
            ]);
        }
        return response()->json([
                'cartItem' => $cartItem,
            ]);
    
    }









}


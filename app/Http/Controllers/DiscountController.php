<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Discount;
use App\Models\Category;
use App\Models\Section;
use App\Models\Sector;


class DiscountController extends Controller
{
    //MAKE THE DISCOUNT
    //I NEED THE PRODUCT ID AND THE NUMBER OF THE DISCOUNT 
    public function makeDiscount(Request $request , $product_id){

        $atter = $request->validate([
            'percentage_off' => ['required']
        ]);

        $discount = Discount::create([
            'product_id' => $product_id,
            'percentage_off' => $atter['percentage_off'],
        ]);

        return response()->json([
            'message' => $discount,
        ]);
    }

    //DELETE DISCOUNT REQUIRE THE ID OF THE DISQUNT
    public function DeleteDiscount($discount_id)
    {
        $discount =  Discount::where('id','=',$discount_id)->first();

        if($discount)
        {
            return response()->json([
                'message' => $discount->delete(),
            ]);
        }
        return response()->json([
            'message' =>'result not found'
        ]);
    }

    //EDIT DISCOUNT REQUIRE THE ID OF THE DISQUNT
    public function EditDiscount(Request $request,$discount_id)
    {
       $discount =  Discount::where('id','=',$discount_id)->get();

        if($discount)
        {
            $newDiscount = $discount->update([
                'percentage_off' => $request->input('percentage_off'),
            ]);
            return response()->json([
                'message' => $newDiscount,
            ]);
        }
        return response()->json([
            'message' =>'result not found'
        ]);
    } 

    public function makeDiscountOncategory(Request $req,$category_id){
        $atter = $req->validate([
            'percentage_off' => ['required']
        ]);
        $category = Category::where('id',$category_id)->first();
        $CatProducts = Product::where('category_id',$category_id)->get()->toArray(); 

        $sections = $category->sections()->get();

        if($sections){

        $products = [];
        foreach ($sections as $section) {
            $products = array_merge($products, $section->getProducts()->get()->toArray());
        }
        $products = array_merge($products, $CatProducts);
        
        foreach($products as $product){
            $existingDiscount = Discount::where('product_id', $product['id'])->first();

            if ($existingDiscount) {
                $existingDiscount->delete();
            }

            $discount = Discount::create([
            'product_id' => $product['id'],
            'percentage_off' => $atter['percentage_off'],
        ]);
        }

        }
        else{
            $products = Product::where('category_id',$category_id)->get(); 
            foreach($products as $product){
            $existingDiscount = Discount::where('product_id', $product['id'])->first();

            if ($existingDiscount) {
                $existingDiscount->delete();
            }

            $discount = Discount::create([
            'product_id' => $product['id'],
            'percentage_off' => $atter['percentage_off'],
        ]);
        }}

        if(!$products){
            return response()->json([
                'message' => 'No product found'
            ]);
        }
        return response()->json([
            'products' => $products
        ]);
    }

    public function makeDiscountOnSection(Request $req,$section_id){
        $atter = $req->validate([
            'percentage_off' => ['required']
        ]);
        $section=Section::where('id',$section_id)->first();
        $SecProducts = Product::where('section_id',$section_id)->get()->toArray(); 
        $sectors =$section->sectors()->get();

        if($sectors->isNotEmpty()){
            $products = [];
            foreach ($sectors as $sector) {
                $products = array_merge($products, $sector->getProducts()->get()->toArray());
            }
            $products = array_merge($products, $SecProducts);
            foreach($products as $product){
                $existingDiscount = Discount::where('product_id', $product['id'])->first();
                if ($existingDiscount) {
                    $existingDiscount->delete();
                }
                
                $discount = Discount::create([
                'product_id' => $product['id'],
                'percentage_off' => $atter['percentage_off'],
            ]);
            }
        } 
        else {
            $products = Product::where('section_id',$section_id)->get();
            foreach($products as $product){
            $existingDiscount = Discount::where('product_id', $product['id'])->first();
            if ($existingDiscount) {
                $existingDiscount->delete();
            }
            
            $discount = Discount::create([
            'product_id' => $product['id'],
            'percentage_off' => $atter['percentage_off'],
            ]);
        }
        if(!$products){
            return response()->json([
                'message' => 'No product found'
            ]);
        }
        }
        return response()->json([
            'products' => $products
        ]);
    }
    
    public function makeDiscountOnSector(Request $req,$sector_id){
        $atter = $req->validate([
            'percentage_off' => ['required']
        ]);
        $sector = Sector::where('id',$sector_id)->first();
        $products = $sector->getProducts()->get();
        if($products){

        foreach($products as $product){
            $existingDiscount = Discount::where('product_id', $product['id'])->first();
            if ($existingDiscount) {
                $existingDiscount->delete();
            }
            
            $discount = Discount::create([
            'product_id' => $product['id'],
            'percentage_off' => $atter['percentage_off'],
        ]);
        }

        return response()->json([
            'products' => $products
        ]);
        }
        else{
        return response()->json([
            'products' => 'no products founds'
        ]);

        }

    }

    public function DeleteSectionOnCategory($category_id){
        $category = Category::where('id',$category_id)->first();
        $CatProducts = Product::where('category_id',$category_id)->get()->toArray(); 
        $sections = $category->sections()->get();
        if($sections){

            $products = [];
            foreach ($sections as $section) {
                $products = array_merge($products, $section->getProducts()->get()->toArray());
            }
            $products = array_merge($products , $CatProducts );
            foreach($products as $product){
                $discount = Discount::where('product_id', $product['id'])->first();
                if ($discount) {
                    $discount->delete();
                }
            }
        }
        else{
            $products = Product::where('category_id',$category_id)->get(); 
            foreach($products as $product){
                $discount = Discount::where(['product_id',$product->id])->first();
                if($discount){
                $discount->delete();
                }
            }
        }
        if(!$products){
            return response()->json([
                'message'=>'product not found'
            ]);
        }
        
        return response()->json([
            'message' => 'delete Success',
        ]);
    }

    public function deleteDiscountOnSection($section_id){
        $section=Section::where('id',$section_id)->first();
        $sectors =$section->sectors()->get();
        if($sectors){

        $products = [];
        foreach ($sectors as $sector) {
            $products = array_merge($products, $sector->getProducts()->get()->toArray());
        }
        foreach($products as $product){

            $discount = Discount::where('product_id',$product['id'])->first();
            if($discount){
            $discount->delete();
            }
        }
        
        }

        else{
            $products = Product::where('section_id',$section_id)->get();
            foreach($products as $product){

            $discount = Discount::where(['product_id',$product->id])->first();
            if($discount){
            $discount->delete();
            }
        }
        }
        if($products){
            return response()->json([
                'message' => 'No products founds',
            ]);
        }

        return response()->json([
            'message' => 'delete Success',
        ]);
    }

    public function deleteDiscountOnSector($sector_id){
        $sector = Sector::where('id',$sector_id)->first();
        $products = $sector->getProducts()->get();
        
        if(!$products){
            return response()->json([
                'message' => 'no products founds',
            ]);
        }
        else{

        foreach($products as $product){
            $discount = Discount::where('product_id',$product->id)->first();
            if($discount){
                $discount->delete();
                continue;
            }
        }
        return response()->json([
            'message' => 'delete Success',
        ]);
        }
    
    }

    public function makeDisForAllProduct(Request $req){
        $atter = $req->validate([
            'percentage_off' => ['required']
        ]);
        $products = Product::all();
        foreach($products as $product){
            $existingDiscount = Discount::where('product_id', $product['id'])->first();
            if ($existingDiscount) {
                $existingDiscount->delete();
            }
            
            $discount = Discount::create([
            'product_id' => $product['id'],
            'percentage_off' => $atter['percentage_off'],
        ]);
        }

        return  response()->json([
            'products' => $products,
        ]);
    } 

    public function getAllDiscounts(){
        $discount = Discount::all();
        return response()->json([
            'discount' => $discount
        ]);
    }   

}

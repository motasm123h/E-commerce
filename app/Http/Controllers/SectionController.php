<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Section;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;


class SectionController extends Controller
{
    public function index($category_id,$sortType=null){
        $section=Section::where('category_id','=',$category_id)->get();
        $category = Category::where('id','=',$category_id)->first();
        if(!$category){
            return response()->json([
                'message' => 'no category',
            ]);
        }
        else{

            if($category->sections->isNotEmpty())
                {
                    return response()->json([
                        'category'=>$category['type'] ?? "no data",
                        'section' => $category->sections()->get(),
                    ],200);
                }
            else if($category->products->isNotEmpty())
            {
                $products = Product::where('category_id',$category_id)->get();
                    if($sortType == 'asc'){
                        $products = Product::where('category_id',$category_id)
                        ->orderBy('name','asc')
                        ->paginate(10);

                        $products->getCollection()->map(function ($product) {
                        $product->load(['discounts' => function ($query) {
                        $query->select('id', 'percentage_off', 'product_id');
                        }]);
                        return $product;
                        });
                    
                    }
                    else if($sortType == 'desc' ){
                        $products = Product::where('category_id',$category_id)
                        ->orderBy('name','desc')
                        ->paginate(10);
                    }
                    else if ($sortType == 'Hprice'){
                        $products = Product::where('category_id',$category_id)
                        ->orderBy('price','desc')
                        ->paginate(10);


                        $products->getCollection()->map(function ($product) {
                        $product->load(['discounts' => function ($query) {
                        $query->select('id', 'percentage_off', 'product_id');
                        }]);
                        return $product;
                        });
                    }
                    else if ($sortType == 'Lprice'){
                        $products = Product::where('category_id',$category_id)
                        ->orderBy('price','asc')
                        ->paginate(10);

                        $products->getCollection()->map(function ($product) {
                        $product->load(['discounts' => function ($query) {
                        $query->select('id', 'percentage_off', 'product_id');
                        }]);
                        return $product;
                        });
                    }
                    else{
                        $products = Product::where('category_id',$category_id)
                        ->paginate(10);

                        $products->getCollection()->map(function ($product) {
                        $product->load(['discounts' => function ($query) {
                        $query->select('id', 'percentage_off', 'product_id');
                        }]);
                        return $product;
                        });
                    }

                foreach($products as $product) 
                    {
                        if(isset($product->discounts[0]))
                        {
                            $discountedPrice = $product->price - (($product->price * $product->discounts[0]->percentage_off) / 100);   
                            $product->final_price = round($discountedPrice, 2);
                            $product->percentage_off = $product->discounts[0]->percentage_off;
                            $product->discount_id = $product->discounts[0]->id;
                        } 
                        else {
                            $product->final_price = round($product->price, 2);
                        }
                    }
                    foreach($products as $product) 
                    {
                    unset($product->discounts);
                    }

                    return response()->json([
                        'products' => $products,
                    ]);
                }
                
                else
                {
                    return response()->json([
                        'section'=>'result not found',
                    ]);
                }
        }

    }

    public function CreateSection(Request $request, $category_id){
        $atter = $request->validate([
            'Section_type' => ['required'],
            'Section_image' => 'required|image|mimes:jpg,png|max:2048',
        ]);

        $imgName = time().'-'.auth()->user()->name.'.'.$request->Section_image->extension();    
        $ImagePath = $request->Section_image->move(public_path('section'),$imgName);

        $section = Section::create([
            'category_id' => $category_id,
            'Section_type' => $atter['Section_type'],
            'Section_image' => $imgName,
        ]);
        return response()->json([
            '$section' => $section,
        ]);
    }
  
    public function EditSection(Request $request, $section_id){
        $section = Section::where([
            'id' => $section_id,
        ])->first();
        if($section){

        $atter = $request->validate([
            'Section_type' => ['required'],
            'Section_image' => 'required|image|mimes:jpg,png|max:2048',
        ]);

        $imgName = time().'-'.auth()->user()->name.'.'.$request->Section_image->extension();    
        $ImagePath = $request->Section_image->move(public_path('section'),$imgName);

        $section->update([
            'Section_type'=>$atter['Section_type'],
            'Section_image'=>$imgName,
        ]);

        return response()->json([
            'section' => $section,
        ]);
        }
        return response()->json([
            'message' => 'result not found'
        ]);
    }

    public function deleteSection($section_id){
        $section=Section::find($section_id);
        if($section){
            $section->delete();
            return response()->json([
                'message' => 'delete Done',
            ],200);
        }

        return response()->json([
            'message' =>'reult not found',
        ]);
    }

}

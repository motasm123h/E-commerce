<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Laptop;
use App\Models\Section;

class LapTopController extends Controller
{

  
    //this for delete laptop 
    //i need the laptop id 


    //edit laptop
    public function editLaptop(Request $request,$laptop_id){
        $laptop = Product::where('id',$laptop_id)->first();

        $laptopName=$request->input('name') ?? $laptop['name'];
        $laptopPrice=$request->input('price') ?? $laptop['price'];
        $laptopBrand=$request->input('Brand') ?? $laptop['Brand'];
        $laptopAvailabilty=$request->input('Availabilty') ?? $laptop['Availabilty'];
        $laptopCode=$request->input('product_code') ?? $laptop['product_code'];
        $laptopType=$request->input('Type') ?? $laptop['Type'];
        $laptopDesc=$request->input('desc') ?? $laptop['desc'];

        $imgName = time().'-'.auth()->user()->name.'.'.$request->image->extension();    
        $ImagePath = $request->image->move(public_path('images'),$imgName);
        
        $laptopImage =  $imgName ?? $laptop['image'];

        $laptop->update([
            'Type'=>$laptopType,
            'price' =>$laptopPrice,
            'name' =>$laptopName,
            'image' =>$laptopImage,
            'Availabilty' =>$laptopAvailabilty,
            'product_code' =>$laptopCode,
            'Brand' =>$laptopBrand,
            'desc' =>$laptopDesc,
        ]);

        return response()->json([
            'laptop'=>$laptop
        ]);



    }

}

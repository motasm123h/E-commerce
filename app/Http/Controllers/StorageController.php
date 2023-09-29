<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\storagedetailes;
use App\Models\Product;


class StorageController extends Controller
{
    public function creaate_Storage_Detailes(Request $request,$product_id){
         $storage = storagedetailes::create([
            'product_id'=>$product_id,
            'Disk_Technology'=>$request->input('Disk_Technology'),
            'Disk_Size'=>$request->input('Disk_Size'),
            'Disk_Capacity'=>$request->input('Disk_Capacity'),
            'Disk_Speed'=>$request->input('Disk_Speed'),
            'Disk_Cache'=>$request->input('Disk_Cache'),
            'Disk_Interface'=>$request->input('Disk_Interface'),
            'Best_Used_For'=>$request->input('Best_Used_For'),
            
            'Flash_Capacity'=>$request->input('Flash_Capacity'),
            'Flash_Type'=>$request->input('Flash_Type'),
            'Interface'=>$request->input('Interface'),
            'Compatible_with'=>$request->input('Compatible_with'),
            
            'Warranty'=>$request->input('Warranty'),
        ]);

        return response()->json([
            'storageDetailes' =>$storage
        ]);
    }
    
    public function storagerEdit(Request $request ,$product_id){
        $storage = storagedetailes::where('product_id',$product_id)->first();

        $storage->update([
            'Disk_Technology'=>$request->input('Disk_Technology') ?? $storage['Disk_Technology'],
            'Disk_Size'=>$request->input('Disk_Size')?? $storage['Disk_Size'],
            'Disk_Capacity'=>$request->input('Disk_Capacity')?? $storage['Disk_Capacity'],
            'Disk_Speed'=>$request->input('Disk_Speed')?? $storage['Disk_Speed'],
            'Disk_Cache'=>$request->input('Disk_Cache')?? $storage['Disk_Cache'],
            'Disk_Interface'=>$request->input('Disk_Interface')?? $storage['Disk_Interface'],
            'Best_Used_For'=>$request->input('Best_Used_For')?? $storage['Best_Used_For'],
            
            'Flash_Capacity'=>$request->input('Flash_Capacity')?? $storage['Flash_Capacity'],
            'Flash_Type'=>$request->input('Flash_Type')?? $storage['Flash_Type'],
            'Interface'=>$request->input('Interface')?? $storage['Interface'],
            'Compatible_with'=>$request->input('Compatible_with')?? $storage['Compatible_with'],
           
            'Warranty'=>$request->input('Warranty')?? $storage['Warranty'],
        ]);

        return response()->json([
            'mointor' => $storage
        ]);
    }

    public function getStorageWithDetails($storage_id){
        $storages=Product::where('id','=',$storage_id)
        ->select()
        ->with(['StorageDetails'])
        ->with(['discounts' => function ($query) {
                $query->select('id','percentage_off','product_id');
            }])
        ->get();

        
        foreach($storages as $storage) 
        {
            if(isset($storage->discounts[0]))
            {
                $discountedPrice = $storage->price - (($storage->price * $storage->discounts[0]->percentage_off) / 100);   
                $storage->final_price = round($discountedPrice, 2);
                $storage->percentage_off = $storage->discounts[0]->percentage_off;
                $storage->discount_id = $storage->discounts[0]->id;
            } 
            else {
                $storage->final_price = round($storage->price, 2);
            }
        }
        foreach($storages as $storage) 
        {
           unset($storage->discounts);
        }


        return response()->json([
            'monitors'=>$storages,
            ]);
    }
    


}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Advert;

class AdverController extends Controller
{
    public function index(){
        $adv = Advert::all();
        return response()->json([
            'adv'=>$adv,
        ]);
    }

    public function addAdv(Request $request){
        $atter = $request->validate([
            'image' =>['required'],
            'type' =>['required'],
        ]);

        $imgName = time().'-'.auth()->user()->name.'.'.$request->image->extension();    
        $ImagePath = $request->image->move(public_path('adv'),$imgName);


        $adv = Advert::create([
            'type' => $atter['type'],
            'image' => $imgName,
        ]);
        return response()->json([
            'adv'=>$adv,
        ]);
    }

    public function editAdv(Request $request,$adv_id){
        $adv = Advert::where('id',$adv_id)->first();
        $imgName;
        if(!$adv){
            return response()->json([
            'adv'=>'adver not found',
        ]);
        }
        if($request->image){
        
        $imgName = time().'-'.auth()->user()->name.'.'.$request->image->extension();    
        $ImagePath = $request->image->move(public_path('adv'),$imgName);

        }
        $adv->update([
            'type' => $request->input('type') ?? $adv['type'],
            'image' => $imgName ?? $adv['image'],
        ]);

        return response()->json([
            'adv'=>$adv,
        ]);
    }

    public function deleteAdvert($adv_id){
        $adv = Advert::where('id',$adv_id)->first();
        
        if(!$adv){
            return response()->json([
            'adv'=>'adver not found',
        ]);
        }
        return response()->json([
            'message' => $adv->delete(),
        ]);
    }
}

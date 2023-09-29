<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Footinfo;

class FooterController extends Controller
{
    public function index(){
        $footerInfo = Footinfo::all();
        if($footerInfo->isEmpty()){
            return response()->json([
                'message' => 'Footer information is empty'
            ]);
        }
        return response()->json([
            'message' => $footerInfo
        ]); 
    }
    public function makeFooter(Request $request){
        $atter = $request->validate([
            'email' => ['required','string','email'],
            'address' => ['required'],
            'description' => ['required'],
            
            // 'faceBook_Account' => ['required'],
            // 'instagram_Account' => ['required'],
            // 'twitter_Account' => ['required'],
        ]);
        $footer = Footinfo::create([
            'email' => $atter['email'],
            'address' => $atter['address'],
            'description' => $atter['description'],
            'numberOne' => $request->input('numberOne'),
            'numberTwo' => $request->input('numberTwo'),
            'numberThree' => $request->input('numberThree'),
            'faceBook_Account' => $request->input('faceBook_Account'),
            'instagram_Account' => $request->input('instagram_Account'),
            'twitter_Account' => $request->input('twitter_Account'),
        ]);

        return response()->json([
            'footer' => $footer
        ]);
    }
    public function deleteFooter($footer_id){
        $footer = Footinfo::where('id',$footer_id)->first();
        if(!$footer){
            return repsonse()->json([
                'message' => 'result not found'
            ]);
        }
        return response()->json([
            'footer' => $footer->delete()
        ]);
    } 
    public function editFooter(Request $request,$footer_id){
        $footer = Footinfo::where('id',$footer_id)->first();
        if(!$footer){
            return repsonse()->json([
                'message' => 'result not found'
            ]);
        }
        $footer->update([
            'email' => $request->input('email') ?? $footer['email'],
            'address' => $request->input('address')?? $footer['address'],
            'numberOne' => $request->input('numberOne')?? $footer['numberOne'],
            'numberTwo' => $request->input('numberTwo')?? $footer['numberTwo'],
            'numberThree' => $request->input('numberThree')?? $footer['numberThreenumberThree'],
            'description' => $request->input('description')?? $footer['description'],
            'faceBook_Account' => $request->input('faceBook_Account') ?? $footer['faceBook_Account'],
            'instagram_Account' => $request->input('instagram_Account') ?? $footer['instagram_Account'],
            'twitter_Account' => $request->input('twitter_Account') ?? $footer['twitter_Account'],
        ]);
        return response()->json([
            'footer' => $footer
        ]);
    } 
}

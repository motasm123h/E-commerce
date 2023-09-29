<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index (){
        $category = Category::all();
        return response()->json([
            'category' => $category,
        ]);
    }
    

    public function MakeCategory(Request $request){
        $atter = $request->validate([
            'type' => ['required']
        ]);

        $category = Category::create([
            'type' => $atter['type'],
        ]);

        return response()->json([
            'category' => $category
        ]);
    }


    public function deleteCategory($id){
        $category=Category::find($id);
        if($category){
            $category->delete();
            return response()->json([
                'message' => 'delete Done',
            ],200);
        }

        return response()->json([
            'message' =>'reult not found',
        ]);

    }

    public function editCategory(Request $request,$id){
        $category=Category::find($id);
        if($category){
            $category->update([
                'type' => $request->input('type'),
            ]);
            return response()->json([
                'message' => 'edit Done',
            ],200);
        }

        return response()->json([
            'message' =>'reult not found',
        ]);

    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Color;


class ColorChossController extends Controller
{
    public function getColor(){
        $colors = Color::all();
        return response()->json([
            'colors' => $colors
        ]);
    }
    public function UpdateColor(Request $request){
        $atter = $request->validate([
            'R'=>['required'],
            'G'=>['required'],
            'B'=>['required'],
            'A' => ['required', 'numeric', 'between:0,1'],
        ]);
        $colors = Color::first();
        $colors->update([
            'R' => $atter['R'],
            'G' => $atter['G'],
            'B' => $atter['B'],
            'A' => $atter['A'],
        ]);
        
        return response()->json([
            'colors' => $colors
        ]);
    }
}

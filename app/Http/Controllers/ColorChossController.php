<?php

namespace App\Http\Controllers;

use App\Http\Requests\ColorRequest;
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
    public function UpdateColor(ColorRequest $request){
        $atter = $request->validated();
        $colors = Color::first();
        $colors->update($atter);
        
        return response()->json([
            'colors' => $colors
        ]);
    }
}

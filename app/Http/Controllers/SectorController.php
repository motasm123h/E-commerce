<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Laptop;
use App\Models\Section;
use App\Models\Category;
use App\Models\Sector;

class SectorController extends Controller
{
    public function getTheSectorForSection($section_id){
        $sections=Section::where('id',$section_id)->first();
        return response()->json([
            'data'=>$sections->sectors()->get(),
            ]);
    }

    public function makeSector(Request $request,$section_id){
       $atter = $request->validate([
        'name' => ['required']
       ]);
        $sector = Sector::create([
            'section_id' => $section_id,
            'name'=>$atter['name'],
        ]);
        return response()->json([
            'sector' => $sector
        ]);
    }

    public function editSector(Request $request,$sector_id){
        $sector = Sector::where('id',$sector_id)->first();

        $sector->update([
            'name'=>$request->input('name') ?? $sector['name'],
        ]);

        return response()->json([
            'sector' => $sector,
        ]);
    }
    public function deleteSector($sector_id){
        $sector = Sector::where('id',$sector_id)->first();
        if($sector){

        return response()->json([
            'sector' => $sector->delete(),
        ]);
        }
        return response->json([
            'sector' => 'sector not found',
        ]);

    }

    
}

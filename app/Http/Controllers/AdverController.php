<?php

namespace App\Http\Controllers;

use App\Class\storeImage;
use App\Http\Requests\AdvRequest;
use Illuminate\Http\Request;
use App\Models\Advert;

class AdverController extends Controller
{
    public function index()
    {
        $adv = Advert::all();
        return response()->json([
            'adv' => $adv,
        ]);
    }

    public function addAdv(AdvRequest $request)
    {
        $im = new storeImage();
        $atter = $request->validated();

        $imgName = $im->storeOneImageForAdv($request->image);

        $adv = Advert::create([
            'type' => $atter['type'],
            'image' => $imgName,
        ]);
        return response()->json([
            'adv' => $adv,
        ]);
    }

    public function editAdv(Request $request, $adv_id)
    {
        $im = new storeImage();
        $adv = Advert::where('id', $adv_id)->first();
        $imgName;
        if (!$adv) {
            return response()->json([
                'adv' => 'adver not found',
            ]);
        }
        if ($request->image) {
            $imgName = $im->storeOneImageForAdv($request->image);
        }
        $adv->update([
            'type' => $request->input('type') ?? $adv['type'],
            'image' => $imgName ?? $adv['image'],
        ]);

        return response()->json([
            'adv' => $adv,
        ]);
    }

    public function deleteAdvert($adv_id)
    {
        $adv = Advert::where('id', $adv_id)->first();

        if (!$adv) {
            return response()->json([
                'adv' => 'adver not found',
            ]);
        }
        return response()->json([
            'message' => $adv->delete(),
        ]);
    }
}

<?php

namespace App\Class;

use App\Models\Images;

class storeImage
{
    public function storeOneImage($image)
    {
        $imgName = time() . '-' . auth()->user()->name . '.' . $image->extension();
        $ImagePath = $image->move(public_path('images'), $imgName);
        return $imgName;
    }
    public function storeOneImageForAdv($image)
    {
        $imgName = time() . '-' . auth()->user()->name . '.' . $image->extension();
        $ImagePath = $image->move(public_path('adv'), $imgName);
        return $imgName;
    }
    public function storeMoreImage($images, $product_id)
    {

        // $imgName = time() . '-' . auth()->user()->name . '.' . $images->extension();
        // $ImagePath = $images->move(public_path('other_images'), $imgName);
        // return $imgName;
        $files = $images;
        $filesCount = is_array($files) ? count($files) : ($files ? 1 : 0);

        if ($filesCount == 1) {
            $imgName = time() . '-' . auth()->user()->name . '.' . $images->extension();
            $ImagePath = $images->move(public_path('other_images'), $imgName);
            $image = Images::create([
                'product_id' => $product_id,
                'name' => $imgName
            ]);
        } else if ($filesCount > 1) {

            if ($images) {
                $imageNames = [];
                foreach ($images as $file) {
                    $imageName = time() . '_' . $file->getClientOriginalName();
                    $ImagePath = $file->move(public_path('other_images'), $imageName);

                    $image = Images::create([
                        'product_id' => $product_id,
                        'name' => $imageName
                    ]);
                    $imageNames[] = $imageName;
                }
            }
        }
    }
}

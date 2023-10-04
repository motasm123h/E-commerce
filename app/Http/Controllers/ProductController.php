<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Laptop;
use App\Models\Section;
use App\Models\Category;
use App\Models\Sector;
use App\Models\Images;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public $query;

    public function __construct()
    {
        $this->query = Product::query();
    }

    function applyDiscountLogic($product) {
        if (isset($product->discounts[0])) {
            $discountedPrice = $product->price - (($product->price * $product->discounts[0]->percentage_off) / 100);
            $product->final_price = round($discountedPrice, 2);
            $product->percentage_off = $product->discounts[0]->percentage_off;
            $product->discount_id = $product->discounts[0]->id;
        } else {
            $product->final_price = round($product->price, 2);
        }
    }
    
    function unsetDiscount($product)
    {
        unset($product->discounts);
    }

    public function ceateproductFroCategory(Request $request , $category_id){
        $atter = $request->validate([
            'Type' =>['required'],
            'price' =>['required'],
            'name' =>['required'],
            'image' =>'required|image|mimes:jpg,png|max:2048',
            // 'Availabilty' =>['required'],
            'product_code' =>['required'],
            'Brand' =>['required'],
            'desc' =>['required'],
            'Quntity' =>['required'],
        ]);
        
        $imgName = time().'-'.auth()->user()->name.'.'.$request->image->extension();    
        $ImagePath = $request->image->move(public_path('images'),$imgName);
        if($atter['Quntity'] == 0){
          $product = Product::create([
            'category_id' => $category_id,
            'Type'=>$atter['Type'],
            'price' =>$atter['price'],
            'name' =>$atter['name'],
            'image' =>$imgName,
            'Availabilty' =>'Out Of Stock',
            'product_code' =>$atter['product_code'],
            'Brand' =>$atter['Brand'],
            'desc' =>$atter['desc'],
            'Quntity' =>$atter['Quntity'],
        ]);  

        }
       else{

        $product = Product::create([
            'category_id' => $category_id,
            'Type'=>$atter['Type'],
            'price' =>$atter['price'],
            'name' =>$atter['name'],
            'image' =>$imgName,
            'Availabilty' =>'In Stock',
            'product_code' =>$atter['product_code'],
            'Brand' =>$atter['Brand'],
            'desc' =>$atter['desc'],
            'Quntity' =>$atter['Quntity'],
        ]);
       }

        $files = $request->file('images');
        $filesCount = is_array($files) ? count($files) : ($files ? 1 : 0);

        if ($filesCount == 1) {
            $imageName = time() . '_' . $request->file('images')->getClientOriginalName();
            $ImagePath = $request->file('images')->move(public_path('other_images'), $imageName);
            $image = Images::create([
                'product_id' => $product['id'],
                'name' => $imageName
            ]);
        } else if ($filesCount > 1) {
            if ($request->hasFile('images')) {
                $imageNames = [];
                foreach ($request->file('images') as $file) {
                    $imageName = time() . '_' . $file->getClientOriginalName();
                    $ImagePath = $file->move(public_path('other_images'), $imageName);
                    $image = Images::create([
                        'product_id' => $product['id'],
                        'name' => $imageName
                    ]);
                    $imageNames[] = $imageName;
                }
            }
        }
        
        if($atter['Quntity'] ==  0){
            $product->update(
                // 'Availabilty' => 
            );
        }
        return response()->json([
            'product' => $product,
        ]);
    }


    //for addmin to create product for section
    public function ceateproductFroSection(Request $request , $section_id){
        $atter = $request->validate([
            'Type' =>['required'],
            'price' =>['required'],
            'name' =>['required'],
            'image' =>'required|image|mimes:jpg,png|max:2048',
            // 'Availabilty' =>['required'],
            'product_code' =>['required'],
            'Brand' =>['required'],
            'desc' =>['required'],
            'Quntity' =>['required'],
            // 'images' => 'required',
            // 'images.*' => 'image|mimes:jpg,png|max:2048',
            
        ]);
        
        $imgName = time().'-'.auth()->user()->name.'.'.$request->image->extension();    
        $ImagePath = $request->image->move(public_path('images'),$imgName);
        


        if($atter['Quntity'] == 0){
          $product = Product::create([
            'category_id' => $section_id,
            'Type'=>$atter['Type'],
            'price' =>$atter['price'],
            'name' =>$atter['name'],
            'image' =>$imgName,
            'Availabilty' =>'Out Of Stock',
            'product_code' =>$atter['product_code'],
            'Brand' =>$atter['Brand'],
            'desc' =>$atter['desc'],
            'Quntity' =>$atter['Quntity'],
        ]);  
        }
        else{
            $product = Product::create([
                'category_id' => $section_id,
                'Type'=>$atter['Type'],
                'price' =>$atter['price'],
                'name' =>$atter['name'],
                'image' =>$imgName,
                'Availabilty' =>'In Stock',
                'product_code' =>$atter['product_code'],
                'Brand' =>$atter['Brand'],
                'desc' =>$atter['desc'],
                'Quntity' =>$atter['Quntity'],
            ]);
       }

       $files = $request->file('images');
        $filesCount = is_array($files) ? count($files) : ($files ? 1 : 0);

        if ($filesCount == 1) {
            $imageName = time() . '_' . $request->file('images')->getClientOriginalName();
            $ImagePath = $request->file('images')->move(public_path('other_images'), $imageName);
            $image = Images::create([
                'product_id' => $product['id'],
                'name' => $imageName
            ]);
        } else if ($filesCount > 1) {
            if ($request->hasFile('images')) {
                $imageNames = [];
                foreach ($request->file('images') as $file) {
                    $imageName = time() . '_' . $file->getClientOriginalName();
                    $ImagePath = $file->move(public_path('other_images'), $imageName);
                    $image = Images::create([
                        'product_id' => $product['id'],
                        'name' => $imageName
                    ]);
                    $imageNames[] = $imageName;
                }
            }
        }
        

        
        return response()->json([
            'laptop' => $product,
        ]);
    } 
    
    //for addmin to create product for sector
    public function ceateproductFroSector(Request $request , $sector_id){
        $sector = Sector::where('id', $sector_id)->first();
        $atter = $request->validate([
            'Type' =>['required'],
            'price' =>['required'],
            'name' =>['required'],
            'image' =>'required|image|mimes:jpg,png|max:2048',
            // 'Availabilty' =>['required'],
            'product_code' =>['required'],
            'Brand' =>['required'],
            'desc' =>['required'],
            'Quntity' =>['required'],
        ]);
        
        $imgName = time().'-'.auth()->user()->name.'.'.$request->image->extension();    
        $ImagePath = $request->image->move(public_path('images'),$imgName);
        

       $imageNames = [];
        $images = $request->file('other_images');
        // dd(count($images));
        if ($request->hasFile('other_images') && is_array($images)) {

        foreach($images as $image) {
            $imgName = time().'-'.auth()->user()->name.'.'.$image->extension();    
            $imagePath = $image->move(public_path('other_images'), $imgName);
            $imageNames[] = $imgName;
        }

        } 

        if($atter['Quntity'] == 0){
          $product = Product::create([
            'category_id' => $sector_id,
            'Type'=>$atter['Type'],
            'price' =>$atter['price'],
            'name' =>$atter['name'],
            'image' =>$imgName,
            'Availabilty' =>'Out Of Stock',
            'product_code' =>$atter['product_code'],
            'Brand' =>$atter['Brand'],
            'desc' =>$atter['desc'],
            'Quntity' =>$atter['Quntity'],
        ]);  
        }
        else{
            $product = Product::create([
                'category_id' => $sector_id,
                'Type'=>$atter['Type'],
                'price' =>$atter['price'],
                'name' =>$atter['name'],
                'image' =>$imgName,
                'Availabilty' =>'In Stock',
                'product_code' =>$atter['product_code'],
                'Brand' =>$atter['Brand'],
                'desc' =>$atter['desc'],
                'Quntity' =>$atter['Quntity'],
            ]);
       }


       $files = $request->file('images');
        $filesCount = is_array($files) ? count($files) : ($files ? 1 : 0);

        if ($filesCount == 1) {
            $imageName = time() . '_' . $request->file('images')->getClientOriginalName();
            $ImagePath = $request->file('images')->move(public_path('other_images'), $imageName);
            $image = Images::create([
                'product_id' => $product['id'],
                'name' => $imageName
            ]);
        } else if ($filesCount > 1) {
            if ($request->hasFile('images')) {
                $imageNames = [];
                foreach ($request->file('images') as $file) {
                    $imageName = time() . '_' . $file->getClientOriginalName();
                    $ImagePath = $file->move(public_path('other_images'), $imageName);
                    $image = Images::create([
                        'product_id' => $product['id'],
                        'name' => $imageName
                    ]);
                    $imageNames[] = $imageName;
                }
            }
        }
        
        return response()->json([
            'laptop' => $product,
        ]);
    }

    //this is for get New product
    public function getNewProduct($sortType = null){
    
        $query = Product::getNewProduct($this->query);

            if ($sortType == 'asc' || $sortType == 'desc') {
                $query->orderBy('name', $sortType);
            } else if ($sortType == 'Hprice') {
                $query->orderBy('price', 'desc');
            } else if ($sortType == 'Lprice') {
                $query->orderBy('price', 'asc');
            } else if ($sortType == 'OLD') {
                $query->orderBy('created_at');
            } else if ($sortType == 'USED') {
                $query->orderByDesc('created_at');
            }

            $products = $query->paginate(10);
       

        foreach ($products as $product) {
            $this->applyDiscountLogic($product);
            $this->unsetDiscount($product);
        }

        return response()->json([
            'products' => $products,
        ]);
    }

    // GET THE USED Products
    public function getUsedProduct($sortType=null){
        
            $query = Product::getUsedProduct($this->query);

            if ($sortType == 'asc' || $sortType == 'desc') {
                $query->orderBy('name', $sortType);
            } else if ($sortType == 'Hprice') {
                $query->orderBy('price', 'desc');
            } else if ($sortType == 'Lprice') {
                $query->orderBy('price', 'asc');
            } else if ($sortType == 'OLD') {
                $query->orderBy('created_at');
            } else if ($sortType == 'USED') {
                $query->orderByDesc('created_at');
            }

            $products = $query->paginate(10);
        

        foreach ($products as $product) {
            $this->applyDiscountLogic($product);
        }

        foreach ($products as $product) {
            $this->unsetDiscount($product);
        }

        return response()->json([
            'products' => $products,
        ]);
    }

    //this is for Discount product
  public function getDiscountedProducts($sortType = null)
    {
        // $cacheKey = 'discounted_products_';

        $query = Product::getDiscontinuedProduct($this->query);

            if ($sortType == 'asc' || $sortType == 'desc') {
                $query->orderBy('name', $sortType);
            } else if ($sortType == 'Hprice') {
                $query->orderBy('price', 'desc');
            } else if ($sortType == 'Lprice') {
                $query->orderBy('price', 'asc');
            } else if ($sortType == 'OLD') {
                $query->orderBy('created_at');
            } else if ($sortType == 'USED') {
                $query->orderByDesc('created_at');
            }

            $productsWithDiscount = $query->paginate(10);
        
        foreach ($productsWithDiscount as $product) {
            $this->applyDiscountLogic($product);
        }

        foreach ($productsWithDiscount as $product) {
            $this->unsetDiscount($product);
        }

        return response()->json([
            'products' => $productsWithDiscount,
        ]);
}

    //GET product DEBENDS ON section Or get the sector if the section have sector
    public function getProductBySection($section_id, $sortType = null)
    {
        $section = Section::where('id', $section_id)->first();

            if (!$section) {
                return response()->json([
                    'message' => 'Section not found'
                ]);
            }

            if ($section->sectors->isNotEmpty()) {
                return response()->json([
                    'sector' => $section->sectors()->get(),
                ]);
            }

            $query = Product::getProductByhereSection($this->query, $section_id);

            if ($sortType == 'desc' || $sortType == 'asc') {
                $query->orderBy('name', $sortType);
            } elseif ($sortType == 'Hprice') {
                $query->orderBy('price', 'desc');
            } elseif ($sortType == 'Lprice') {
                $query->orderBy('price', 'asc');
            } elseif ($sortType == 'OLD') {
                $query->orderBy('created_at');
            } elseif ($sortType == 'NEW') {
                $query->orderByDesc('created_at');
            }

            $products = $query->paginate(10);

            foreach ($products as $product) {
                $this->applyDiscountLogic($product);
            }

            foreach ($products as $product) {
                $this->unsetDiscount($product);
            }



            return response()->json([
                'products' => $products,
            ]);
    }

    public function getProductBySector($sector_id, $sortType = null)
    {
        $sector = Sector::where('id', $sector_id)->first();
        if (!$sector) {
            return response()->json([
                'message' => 'No such sector'
            ]);
        } else {
            if ($sector->getProducts->isEmpty()) {
                return response()->json([
                    'message' => 'No products for this sector',
                ]);
            }

            $query = Product::getProductBySector($this->query, $sector_id);
                
                if ($sortType == null) {
                    $query->paginate(10);
                } elseif ($sortType == 'desc' || $sortType == 'asc') {
                    $query->orderBy('name', $sortType);
                } elseif ($sortType == 'Hprice') {
                    $query->orderBy('price', 'desc');
                } elseif ($sortType == 'Lprice') {
                    $query->orderBy('price', 'asc');
                } elseif ($sortType == 'OLD') {
                    $query->orderBy('created_at');
                } elseif ($sortType == 'NEW') {
                    $query->orderByDesc('created_at');
                }
                
                $products = $query->paginate(10);
                
                foreach ($products as $product) {
                    $this->applyDiscountLogic($product);
                }
                
                foreach ($products as $product) {
                    $this->unsetDiscount($product);
                }
                
        
            return response()->json([
                'products' => $products,
            ]);
        }
    }
    //this is for delete products
    public function deleteProduct($product_id){
        $product = Product::where('id',$product_id)->first();

        if($product){
            return response()->json([
                'message'=>$product->delete(),
            ]);
        }
        return response()->json([
            'message'=>'product didnt found ',
        ]);
    }


    public function editProduct(Request $request,$laptop_id){
        $product = Product::where('id',$laptop_id)->first();

        $productName=$request->input('name') ?? $product['name'];
        $productPrice=$request->input('price') ?? $product['price'];
        $productBrand=$request->input('Brand') ?? $product['Brand'];
        $productAvailabilty=$request->input('Availabilty') ?? $product['Availabilty'];
        $productCode=$request->input('product_code') ?? $product['product_code'];
        $productType=$request->input('Type') ?? $product['Type'];
        $productDesc=$request->input('desc') ?? $product['desc'];

        $product->update([
            'Type'=>$productType,
            'price' =>$productPrice,
            'name' =>$productName,
            'Availabilty' =>$productAvailabilty,
            'product_code' =>$productCode,
            'Brand' =>$productBrand,
            'desc' =>$productDesc,
            'Quntity'=> $request->input('Quntity') ?? $product['Quntity'],
        ]);

        return response()->json([
            'laptop'=>$product
        ]);



    }


    // public function getProductWithDetails($product_id)
    // {   
        
    //     $product ;
    //     $query = Product::where('id', $product_id)
    //         ->select()
    //         ->with(['discounts' => function ($query) {
    //             $query->select('id','percentage_off','product_id');
    //         }])
    //         ->with(['images' => function ($query) {
    //             $query->select('*');
    //         }]);
    //     $product = $query->get();


    //     if(!$product) {
    //         return response()->json([
    //             'product' => 'there is no product like this'
    //         ]);
    //     }
    //     $section = $product->section()->first();
    //     if(!$section){
    //         $product=Product::where('id','=',$product_id)
    //         ->select()
    //         ->with(['discounts' => function ($query) {
    //                 $query->select('id','percentage_off','product_id');
    //             }])
    //         ->with(['images' => function ($query) {
    //             $query->select('*');
    //         }])    
    //         ->get();


            

    //         return response()->json([
    //             'products'=>$product,
    //             ]);
    //     }
        
    //     $category = $section->category()->first();
        
    //     if($category['id'] == 1 || $category['id'] == 2){        
    
    //         $query->with(['Details' => function ($query) {
    //         $query->select('*');
    //         }]);
                  
    //     }
    //     if($category['id'] == 3){        
            
    //         $query->with(['MonitorDetails'=>function($query){
    //                 $query->select('*');
    //         }]);

    //     }

    //     $product = $query->get();
        
        
    //     return response()->json([
    //         'products' => $product,
    //     ]);
        
    // }

//     public function getProductWithDetails($product_id)
// {   
//     $product ;
//     $query = Product::where('id', $product_id)
//         ->select()
//         ->with(['discounts' => function ($query) {
//             $query->select('id','percentage_off','product_id');
//         }])
//         ->with(['images' => function ($query) {
//             $query->select('*');
//         }]);

//         $product = $query->get();
    
//     if(!$product) {
//         return response()->json([
//             'product' => 'there is no product like this'
//         ]);
//     }
//     // if(){}
    
//     $section = $product->section()->first();
//     $category = $section->category()->first();
    
    
//     if($category['id'] == 1 || $category['id'] == 2){
//         $query->with(['Details' => function ($query) {
//             $query->select('*');
//         }]);
//     }
//     elseif($category['id'] == 3){
//         $query->with(['MonitorDetails' => function ($query) {
//             $query->select('*');
//         }]);
//     }
    
//     $products = $query->get();
    
//     foreach($products as $product) {
//         $this->applyDiscountLogic($product);
//     }
    
//     foreach($products as $product) {
//         $this->unsetDiscount($product);
//     }
    
//     return response()->json([
//         'products' => $products,
//     ]);
// }

    public function getProductWithDetails($product_id){   
        $product ;
        $query = Product::where('id', $product_id)
            ->select('*')
            ->with(['discounts' => function ($query) {
                $query->select('id','percentage_off','product_id');
            }])
            ->with(['images' => function ($query) {
                $query->select('*');
            }]);

            $product = $query->first();
            // dd($product);
            if($product['category_id'] == 1 || $product['category_id'] == 2 || $product['section_id'] == 1 || $product['section_id'] == 2 || $product['section_id'] == 3 || $product['section_id'] == 4 || $product['section_id'] == 5 || $product['section_id'] == 6 || $product['section_id'] == 7|| $product['section_id'] == 8){
                $query->with(['Details' => function ($query) {
                    $query->select('*');
            }]);
            }
            elseif($product['category_id'] == 3 || $product['section_id'] == 9 || $product['section_id'] == 10){
                $query->with(['MonitorDetails' => function ($query) {
                    $query->select('*');
            }]);
            }
            $product = $query->get();

            return response()->json([
                'products' => $product,
            ]);
    }

}

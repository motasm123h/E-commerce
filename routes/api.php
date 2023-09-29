<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AdverController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\LapTopController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\MonitorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\StorageController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\TranslateController;
use App\Http\Controllers\ColorChossController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\LapTopDetailsController;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post("register",[AuthController::class,'register']);
Route::post("login",[AuthController::class,'login']);

Route::middleware(['auth:sanctum'])->group(function(){

    Route::post("logout",[AuthController::class,'logout']);

        Route::middleware('AdminMiddleware')->group(function(){
            //this to make new category
            Route::post("MakeCategory",[CategoryController::class,'MakeCategory']);
            //this to delete categories
            Route::delete("deleteCategory/{category_id}",[CategoryController::class,'deleteCategory']);
            //edit category
            Route::post("EditCategory/{category_id}",[CategoryController::class,'editCategory']);



            //this create new section 
            Route::post("category/{id}/MakeSection",[SectionController::class,'CreateSection']);
            //this for delete section
            Route::delete("category/deleteSection/{Section_id}",[SectionController::class,'deleteSection']);
            //edit section
            Route::post("category/editSection/{Section_id}",[SectionController::class,'EditSection']);




            //this create new sector and for this i need the id of the section 
            Route::post("category/Section/{id}/makeSector",[SectorController::class,'makeSector']);
            //this for delete sector
            Route::delete("category/Section/{id}/deleteSectoe",[SectorController::class,'deleteSector']);
            //this create edit sector and for this i need the id of the section 
            Route::post("category/Section/{id}/editSector",[SectorController::class,'editSector']);


            //this for create product in category and this use for all category 
            Route::post("category/{category_id}",[ProductController::class,'ceateproductFroCategory']);
            //this for create product in section and this use for all section
            Route::post("category/Section/{section_id}",[ProductController::class,'ceateproductFroSection']);
            //this for create product in sector and this use for all sector 
            Route::post("category/Section/sector/{sector_id}",[ProductController::class,'ceateproductFroSector']);



            //THIS FOR MAKE THE DELTAILS FOR LAPTOP & Desktop
            Route::post("category/Section/laptop/{product_id}",[LapTopDetailsController::class,'createLapTopDetails']);
            //this for edit the details of laptop or desktop
            Route::post("category/Section/laptop/detailes/edit/{product_id}",[LapTopDetailsController::class,'editLaptopDetails']);


            //THIS FOR MAKE THE DEISCOUNT ON PRODUCT
            Route::post("category/Section/product/{product_id}/makeDiscount",[DiscountController::class,'makeDiscount']);
            //THIS FOR MAKE THE DEISCOUNT ON category
            Route::post("category/Section/product/{category_id}/makeDiscountOnCategory",[DiscountController::class,'makeDiscountOncategory']);
            //THIS FOR MAKE THE DEISCOUNT ON section
            Route::post("category/Section/product/{section_id}/makeDiscountOnSection",[DiscountController::class,'makeDiscountOnSection']);
            //THIS FOR MAKE THE DEISCOUNT ON sector
            Route::post("category/Section/product/{sector_id}/makeOnSectorDiscount",[DiscountController::class,'makeDiscountOnSector']);
            //THIS FOR DELETE THE DEISCOUNT ON PRODUCT
            Route::post("category/Section/product/{product_id}/DeleteDiscount",[DiscountController::class,'DeleteDiscount']);
            //THIS FOR DELETE THE DEISCOUNT ON category
            Route::post("category/Section/product/{category_id}/DeleteDiscountOnCategory",[DiscountController::class,'DeleteSectionOnCategory']);
            //THIS FOR DELETE THE DEISCOUNT ON section
            Route::post("category/Section/product/{section_id}/DeleteDiscountOnSection",[DiscountController::class,'deleteDiscountOnSection']);
            //THIS FOR DELETE THE DEISCOUNT ON sector
            Route::post("category/Section/product/{sector_id}/DeleteDiscountOnSector",[DiscountController::class,'deleteDiscountOnSector']);            
            //THIS FOR edit THE DEISCOUNT ON product
            Route::post("category/Section/product/{discount_id}/editDiscountOnProduct",[DiscountController::class,'EditDiscount']);
            //this is for make discount on products
            Route::post("category/Section/product/makeDisForAllProduct",[DiscountController::class,'makeDisForAllProduct']);
            //this is for get all discount
            Route::get("category/Section/product/getAllDiscounts",[DiscountController::class,'getAllDiscounts']);

            //THIS  FOR DELETE LAPTOP & Desktop
            Route::Delete("category/Section/product/delete/{laptop_id}",[ProductController::class,'deleteProduct']);
            //this is for EDIT product
            Route::post("category/Section/product/edit/{laptop_id}",[ProductController::class,'editProduct']);


            //THIS FOR MAKE THE Mointor detailss
            Route::post("category/Section/monitor/{product_id}",[MonitorController::class,'make_the_Monitor_Details']);
            //THIS FOR edit THE Mointor detailss
            Route::post("category/Section/monitor/details/edit/{product_id}",[MonitorController::class,'monitorEdit']);
            
            //THIS FOR MAKE THE Storage detailss
            Route::post("category/Section/storage/{product_id}",[StorageController::class,'creaate_Storage_Detailes']);
            //this for edit storage
            Route::post("category/Section/storage/details/edit/{product_id}",[StorageController::class,'storagerEdit']);
            

            //get all the user
            Route::get("users/show",[AuthController::class,'getUser']);
            //get selected user
            Route::get("user/show/{id}",[AuthController::class,'findUser']);
            //make user admin
            Route::post("user/{id}/MakeAdmin",[AuthController::class,'makeUserAdmin']);

            //this is for the admin to change the order situation
            Route::post("product/order/edit/{order_id}",[OrderController::class,'updateOrder']);


            //this is for show product
            Route::get("product/getSippedOrder",[OrderController::class,'getShippedOrder']);
            Route::get("product/getArrivedOrder",[OrderController::class,'getArrivedOrder']);
            Route::get("product/getInStockOrder",[OrderController::class,'getInStockOrder']);
            Route::get("product/allOrder",[OrderController::class,'getAlOrder']);

            //this is for accept order
            Route::post('product/AcceptOrder/{id}',[OrderController::class,'AcceptOrder']);
            //this is for reject order
            Route::post('product/RejectOrder/{id}',[OrderController::class,'RejectOrder']);



            //this is for make the footer and edit and delete it
            Route::post("footer/makeInfo",[FooterController::class,'makeFooter']);
            Route::post("footer/delete/{footer_id}",[FooterController::class,'deleteFooter']);
            Route::post("footer/edit/{footer_id}",[FooterController::class,'editFooter']);


            //update the color
            Route::post("updateColor",[ColorChossController::class,'UpdateColor']);



        });

    //this to get the get the category
    Route::get("getCategory",[CategoryController::class,'index']);
    //this to get the section of the category that you will give the id to me
    Route::get("category/getSection/{id}/{sortType?}",[SectionController::class,'index']);
    //this get product by here section and if i want to fillter the result  
    Route::get("category/Section/getProductBySection/{section_id}/{sortType?}",[ProductController::class,'getProductBySection']);
    //this get product by here sector and if i want to fillter the result  
    Route::get("category/Section/Sector/getProductBySector/{sector_id}/{sortType?}",[ProductController::class,'getProductBySector']);
    


    //GET THE NEW PRODUCT and if i want to fillter the result
    Route::get("category/NewProduct/{sortType?}",[ProductController::class,'getNewProduct']);
    //GET THE USED PRODUCT
    Route::get("category/UsedProduct/{sortType?}",[ProductController::class,'getUsedProduct']);
    //GET THE PRODUCT THAT HAVE DISCOUNT and if i want to fillter the result 
    Route::get("category/DiscountProduct/{sortType?}",[ProductController::class,'getDiscountedProducts']);



    //this is for get the product with detailes
    Route::get("category/section/products/{product_id}",[ProductController::class,'getProductWithDetails']);
    



    //this is for make product fav
    Route::post("category/section/MakeFavproduct/{product_id}",[FavoriteController::class,'makeOrDeleteFavorites']);
    //this is for get my fav product
    Route::get("category/section/getFavproduct",[FavoriteController::class,'getFavProduct']);




    //this is for show the item in the cart
    Route::get("product/CartItems",[CartController::class,'index']);
    //this is for add item to the cart
    Route::post("product/addToCart",[CartController::class,'addItemToCart']);
    //this is for delete the items from the cart
    Route::post("product/deleteItmeFromCart",[CartController::class,'deleteItemFromCart']);
    //this is for delete one item from cart
    Route::post("product/deleteOneItmeFromCart",[CartController::class,'deleteOneItemFromCart']);

    //this is for make the check out
    Route::post("product/checkOut",[OrderController::class,'CheackOut']);
    //this is for show my previous order
    Route::get("product/getMyorder",[OrderController::class,'getAuthOrder']);
    //this is for getProduct Stutas
    Route::get("product/getProductByHereStutas/{stutas}",[OrderController::class,'getOrderWithStutas']);
    

   
    //this is for see the footer 
    Route::get("footer/getInfo",[FooterController::class,'index']);

    Route::get("profile/userInfo",[AuthController::class,'getUserInfo']);
    Route::post("profile/userInfo/edit",[AuthController::class,'updateUserInfo']);


    //this route for notification 
    Route::get('getNotifications',[NotificationController::class,'getNotifications']);
    Route::post('markAsRead/{id}',[NotificationController::class,'markNotificationsAsRead']);
    Route::post('deleteNotification/{id}',[NotificationController::class,'deleteNotification']);


    Route::get("translat",[TranslateController::class,'index']);

    Route::get("ads/getAdds",[AdverController::class,'index']);
    Route::post("ads/makeAdds",[AdverController::class,'addAdv']);
    Route::post("ads/editAdds/{id}",[AdverController::class,'editAdv']);
    Route::post("ads/deleteAdds/{id}",[AdverController::class,'deleteAdvert']);

    
    Route::get("sreach/{req}",[SearchController::class,'index']);



    Route::get("colorGet",[ColorChossController::class,'getColor']);

});
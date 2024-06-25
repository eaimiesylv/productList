<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// unprotected route
Route::group(['prefix'=>'v1'], function(){
   
    route::resource('all-customers', App\Http\Controllers\Users\CustomerController::class)->only('index','show');
    route::post('login', App\Http\Controllers\Auth\AuthController::class);


  
    
    route::resource('users', App\Http\Controllers\Users\UserController::class)->only('store');
    route::resource('products', App\Http\Controllers\Product\ProductController::class);
    Route::resource('medias', App\Http\Controllers\Tested\MediaController::class);
    route::get('dashboards',function(){

        $totalProducts = \App\Models\Product::count();
        $totalMedia =  \App\Models\Media::count();

        return response()->json([
            'total_products' => $totalProducts,
            'total_media' => $totalMedia,
            'total_download' => 0,
            'total_view' => 0,
        ]);
        
    });

      
  
   
});

// protected route
Route::middleware('auth:sanctum')->group(function() {

    Route::group(['prefix'=>'v1'], function(){
        route::post('log-out', App\Http\Controllers\Auth\LogOutController::class);
      
     
       
    });
    
   



});







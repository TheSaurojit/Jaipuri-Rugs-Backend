<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\OrderController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;




// Route::post('/contact-us',[ContactUsController::class,'store']) ;

// Route::post('/create-order',[OrderController::class,'createOrder']) ;

Route::post('/users',[ApiController::class,'createUser']);

Route::get('/categories',[ApiController::class,'getCategories']);

Route::get('/products',[ApiController::class,'getProducts']);

Route::get('/products/{productId}',[ApiController::class,'getProductById']);

Route::get('/product-collections',[ApiController::class,'getProductCollections']);





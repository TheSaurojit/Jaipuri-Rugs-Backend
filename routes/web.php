<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductCollectionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;


Route::get('/login', [AuthController::class, 'loginView'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {

    Route::get('/change-password', [AuthController::class, 'changePasswordView'])->name('change-password');
    Route::post('/change-password', [AuthController::class, 'changePassword'])->name('change-password');

    Route::get('/', [HomeController::class, 'home'])->name('home');

    Route::prefix('products')->controller(ProductController::class)->as('products.')->group(function () {


        Route::get('/', 'allProduct')->name('all');

        Route::get('/create', 'createView')->name('create');
        Route::post('/create', 'create')->name('create');

        Route::get('/update/{product}', 'updateView')->name('update');
        Route::post('/update/{product}', 'update')->name('update');

        Route::get('/delete/{product}', 'destroy')->name('delete');
    });

    Route::prefix('categories')->controller(CategoryController::class)->as('categories.')->group(function () {


        Route::get('/', 'allCategory')->name('all');

        Route::get('/create', 'createView')->name('create');
        Route::post('/create', 'create')->name('create');

        Route::get('/update/{category}', 'updateView')->name('update');
        Route::post('/update/{category}', 'update')->name('update');

        Route::get('/delete/{category}', 'destroy')->name('delete');
    });

    Route::prefix('product-collections')->controller(ProductCollectionController::class)->as('product-collections.')->group(function () {
        Route::get('/', 'index')->name('all');
        Route::get('/create', 'create')->name('create');
        Route::post('/create', 'store')->name('store');
        Route::get('/edit/{product_collection}', 'edit')->name('edit');
        Route::put('/update/{product_collection}', 'update')->name('update');
        Route::get('/delete/{product_collection}', 'destroy')->name('destroy');
    });

    Route::prefix('orders')->controller(OrderController::class)->as('orders.')->group(function () {

        Route::get('/', 'allOrder')->name('all');

        Route::get('/view/{order}', 'show')->name('view');

        Route::get('/update/{order}', 'updateView')->name('update');

        Route::post('/update/{order}', 'update')->name('update');


        Route::post('/update-status/{order}', 'updateStatus')->name('update-status');

        Route::get('/invoice/{order}', 'invoice')->name('invoice');
    });

    Route::prefix('contact-us')->controller(ContactUsController::class)->as('contact.')->group(function () {

        Route::get('/', 'allContact')->name('all');

        // Route::get('/view/{contact}', 'view')->name('view');

    });




    Route::get('/settings', [SettingController::class, 'updateView'])->name('settings');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings');
});

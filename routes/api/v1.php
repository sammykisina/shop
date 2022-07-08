<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
})->name('auth:me');

/**
 * Products Routes
 */
Route::prefix('products')->as('products:')->group(function () {

    /**
     * Show All Products
     */
    Route::get(
        '/',
        App\Http\Controllers\Api\V1\Products\IndexController::class
    )->name('index'); // route('api:v1:products:index')

    Route::get(
        '{uuid}',
        App\Http\Controllers\Api\V1\Products\ShowController::class
    )->name('show'); // route('api:v1:products:index')

    
});

/**
 * Cart Routes
 */
Route::prefix('carts')->as('carts:')->group( function() {
    /**
     * Get The Current Users Cart
     */
    Route::get('/', App\Http\Controllers\Api\V1\Carts\IndexController::class)->name('index'); 

    /**
     * Create A New Cart
     */
    Route::post('/',App\Http\Controllers\Api\V1\Carts\StoreController::class)->name('store');

    /**
     * Add Product To Cart
     */
    Route::post('{cart:uuid}/products',App\Http\Controllers\Api\V1\Carts\Products\StoreController::class)->name('products:store');

    /**
     * Update Quantity
     */
    Route::patch('{cart:uuid}/products/{item:uuid}',App\Http\Controllers\Api\V1\Carts\Products\UpdateController::class)->name('products:update');

    /**
     * Delete Product From Cart
     */
    Route::delete('{cart:uuid}/products/{item:uuid}',App\Http\Controllers\Api\V1\Carts\Products\DeleteController::class)->name('products:delete');

    /**
     * Add A Coupon To Cart
     */
    Route::post('{cart:uuid}/coupons',App\Http\Controllers\Api\V1\Carts\Coupons\StoreController::class)->name('coupons:store');

});

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
        App\Http\Controllers\Api\V1\Products\ShowController::class
    )->name('show'); // route('api:v1:products:show')

    
});

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Ecom\Auth\AuthController;
use App\Http\Controllers\Ecom\Admin\Products;
use App\Http\Controllers\Ecom\Admin\Categories;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Authentication routes
Route::group(['prefix' => 'user'], function () { 
	Route::post('/login', [AuthController::class, 'login']);
	Route::post('/register', [AuthController::class, 'register']);
});

Route::group(['prefix' => 'admin'], function () { 
	/* Products */	
	Route::get('/products/get', [Products::class, 'getAllProducts'])->name('product-fetch-all');
	Route::post('/products/store', [Products::class, 'storeProduct'])->name('product-store');
	Route::get('/products/edit/{id}', [Products::class, 'editProduct'])->name('product-edit-data');
	Route::post('/products/update', [Products::class, 'updateProduct'])->name('product-update');
	Route::delete('/products/delete/{id}', [Products::class, 'deleteProduct'])->name('product-delete');
	 
	/* Categories */
	Route::get('/categories/get', [Categories::class, 'getAllCategories'])->name('category-fetch-all');
	Route::post('/categories/store', [Categories::class, 'storeCategory'])->name('category-store');
	Route::get('/categories/edit/{id}', [Categories::class, 'editCategory'])->name('category-edit-data');
	Route::post('/categories/update', [Categories::class, 'updateCategory'])->name('category-update');
	Route::delete('/categories/delete/{id}', [Categories::class, 'deleteCategory'])->name('category-delete');
});

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
	Route::post('/user/logout', [AuthController::class, 'logout']);
});

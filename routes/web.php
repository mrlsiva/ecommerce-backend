<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Ecom\Admin\Products;
use App\Http\Controllers\Ecom\Admin\Categories;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

//Clear All 
Route::get('/clear', function() {
   Artisan::call('cache:clear');
   Artisan::call('config:clear');
   Artisan::call('config:cache');
   Artisan::call('view:clear');
   Artisan::call('route:clear');
   return "All Cleared!";
});


//Language Translation
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);

Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');

//Update User Details
Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');

Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');

Route::middleware('auth')->group(function () {
    Route::group(['prefix' => 'admin'], function () {     
	
		/* Products */
        Route::get('/products', [Products::class, 'showProductsPage'])->name('show-products-page');
        Route::get('/products/get', [Products::class, 'getAllProducts'])->name('get-all-products');
        Route::get('/products/create', [Products::class, 'createProduct'])->name('create-product');
		Route::post('/products/store', [Products::class, 'storeProduct'])->name('store-product');
		Route::get('/products/edit/{id}', [Products::class, 'editProduct'])->name('edit-product');
		Route::post('/products/update', [Products::class, 'updateProduct'])->name('update-product');
		Route::delete('/products/delete/{id}', [Products::class, 'deleteProduct'])->name('delete-product');

		/* Categories */
        Route::get('/categories', [Categories::class, 'showCategories'])->name('show-categories');
        Route::get('/categories/create', [Categories::class, 'createCategory'])->name('create-category');        
        Route::get('/categories/get', [Categories::class, 'getAllCategories'])->name('get-all-categories');
        Route::post('/categories/store', [Categories::class, 'storeCategory'])->name('store-category');
        Route::get('/categories/edit/{id}', [Categories::class, 'editCategory'])->name('edit-category');
        Route::post('/categories/update', [Categories::class, 'updateCategory'])->name('update-category');
		Route::delete('/categories/delete/{id}', [Categories::class, 'deleteCategory'])->name('delete-category');
    });
});    




/* ================== Clear Cache Routes ================== */
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});

//Reoptimized class loader:
Route::get('/optimize', function() {
    $exitCode = Artisan::call('optimize');
    return '<h1>Reoptimized class loader</h1>';
});

//Route cache:
Route::get('/route-cache', function() {
    $exitCode = Artisan::call('route:cache');
    return '<h1>Routes cached</h1>';
});

//Clear Route cache:
Route::get('/route-clear', function() {
    $exitCode = Artisan::call('route:clear');
    return '<h1>Route cache cleared</h1>';
});

//Clear View cache:
Route::get('/view-clear', function() {
    $exitCode = Artisan::call('view:clear');
    return '<h1>View cache cleared</h1>';
});

//Clear Config cache:
Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Clear Config cleared</h1>';
});

//Clear All 
Route::get('/clear', function() {
   Artisan::call('cache:clear');
   Artisan::call('config:clear');
   Artisan::call('config:cache');
   Artisan::call('view:clear');
   Artisan::call('route:clear');
   return "All Cleared!";
});

Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    Artisan::call('view:clear');
    return "Cache is cleared";
});
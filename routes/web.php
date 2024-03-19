<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialController;

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

require __DIR__.'/auth.php';

Route::get('/', function () {
    return view('landing');
})->middleware('customer')->name('/');

Route::get('/products', 
    [App\Http\Controllers\ProductController::class, 'index'])->middleware('customer')->name('products');
    
Route::get('/products/{id}', 
    [App\Http\Controllers\ProductController::class, 'show'])->middleware('customer');
        
Route::post('/products/{id}', 
    [App\Http\Controllers\ProductController::class, 'store'])->middleware(['auth']);
    
Route::delete('/products/{id}', 
    [App\Http\Controllers\ProductController::class, 'destroy'])->middleware(['auth']);

Route::get('/profile', 
    [App\Http\Controllers\ProfileController::class, 'index'])->middleware('auth')->name('profile');

Route::get('/cart', 
    [App\Http\Controllers\CartController::class, 'index'])->middleware('auth')->name('cart');

Route::get('/cart/checkout', 
    [App\Http\Controllers\CartController::class, 'show'])->middleware('auth')->name('cart.checkout');
    
Route::post('/cart/checkout', 
    [App\Http\Controllers\CartController::class, 'store'])->middleware('auth');

Route::get('/admin', function () { return view('admin.index'); })->middleware('admin')->name('admin');
    
Route::get('/admin/login', 
    [App\Http\Controllers\Admin\LoginController::class, 'index'])->middleware('admin')->name('admin.login');

Route::post('/admin/login', 
    [App\Http\Controllers\Admin\LoginController::class, 'store']);

Route::post('/admin/logout', 
    [App\Http\Controllers\Admin\LoginController::class, 'destroy'])->middleware('admin')->name('admin.logout');

Route::get('/admin/products', 
    [App\Http\Controllers\Admin\ProductController::class, 'index'])->middleware('admin')->name('admin.products');

Route::post('/admin/products', 
    [App\Http\Controllers\Admin\ProductController::class, 'store'])->middleware('admin');

Route::put('/admin/products', 
    [App\Http\Controllers\Admin\ProductController::class, 'update'])->middleware('admin')->name('admin.products');

Route::delete('/admin/products', 
    [App\Http\Controllers\Admin\ProductController::class, 'destroy'])->middleware('admin');

Route::get('/admin/customer', 
    [App\Http\Controllers\Admin\CustomerController::class, 'index'])->middleware('admin')->name('admin.customer');

Route::get('/admin/customer/{id}', 
    [App\Http\Controllers\Admin\CustomerController::class, 'show'])->middleware('admin');

Route::post('/admin/customer', 
    [App\Http\Controllers\Admin\CustomerController::class, 'update'])->middleware('admin');

Route::get('/admin/orders', 
    [App\Http\Controllers\Admin\OrderController::class, 'index'])->middleware('admin')->name('admin.orders');

Route::get('/admin/orders/{id}', 
    [App\Http\Controllers\Admin\OrderController::class, 'show'])->middleware('admin');

Route::get('auth/facebook', [SocialController::class, 'facebookRedirect']);

Route::get('auth/facebook/callback', [SocialController::class, 'loginWithFacebook']);

Route::get('auth/github', [SocialController::class, 'gitRedirect']);

Route::get('auth/github/callback', [SocialController::class, 'gitCallback']);
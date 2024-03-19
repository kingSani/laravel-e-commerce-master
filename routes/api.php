<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::get('/cart/{id}', 
    [App\Http\Controllers\ApiController::class, 'getUserCart']);

Route::get('/products', 
    [App\Http\Controllers\ApiController::class, 'getAllProducts']);

Route::get('/products/search/{text}', 
    [App\Http\Controllers\ApiController::class, 'searchProducts']);

Route::get('/chat', 
    [App\Http\Controllers\ApiController::class, 'getAllChat']);

Route::get('/chat/{id}', 
    [App\Http\Controllers\ApiController::class, 'getUserChat']);

Route::post('/chat', 
    [App\Http\Controllers\ApiController::class, 'sendMessage']);

Route::get('/users',
    [App\Http\Controllers\ApiController::class, 'getAllCustomers']);
    
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

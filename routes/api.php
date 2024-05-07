<?php

use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('/products', [ProductController::class, 'getProducts']);
Route::get('/product/{id}/prices', [ProductController::class, 'getPrice']);
//Route::put('/product/{id}', [ProductController::class, 'update']);
//Route::delete('/product/{id}', [ProductController::class, 'delete']);

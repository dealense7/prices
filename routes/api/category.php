<?php

use App\Http\Controllers\Api\CategoryController;
use Illuminate\Support\Facades\Route;


Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'findItems']);
});

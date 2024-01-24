<?php

\Route::prefix(config('crm.prefix','admin'))->group(function($route){
    Route::apiResource('product',Marol\Http\Controllers\Product\IndexController::class)->middleware(['auth:sanctum']);
});


\Route::prefix('api')->group(function($route){
    Route::apiResource('product',Marol\Http\Controllers\Product\IndexController::class);
    Route::apiResource('pc',Marol\Http\Controllers\Product\CategoryController::class);
});
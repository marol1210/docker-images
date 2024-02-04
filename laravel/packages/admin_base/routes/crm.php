<?php

\Route::prefix('api')->middleware(['web','api'])->group(function($route){
    Route::apiResource('product',Marol\Http\Controllers\Product\IndexController::class);
    Route::apiResource('pc',Marol\Http\Controllers\Product\CategoryController::class);
    Route::apiResource('role',Marol\Http\Controllers\Role\IndexController::class);
    Route::apiResource('account',Marol\Http\Controllers\UserController::class);
});
<?php

\Route::prefix(config('crm.prefix','admin'))->group(function($route){
    Route::get('/product',function(){
        return 'ok';
    });
});
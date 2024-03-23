<?php

use Illuminate\Support\Facades\Route;


Route::middleware('api_key')->prefix('api')->group(function () {
    Route::get('/', 'ApiController@index');
    Route::get('/data', 'ApiController@getData');
    Route::post('/create', 'ApiController@createData');
});

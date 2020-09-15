<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->group(function(){
    Route::post('/products','ProductController@store');
    Route::get('/products/{product}','ProductController@show');
    Route::patch('/products/{product}','ProductController@update');
    Route::delete('/products/{product}', 'ProductController@destroy');
});

Route::post('/classification','ClassificationController@store');
Route::patch('/classification/{classification}','ClassificationController@update');
Route::delete('/classification/{classification}','ClassificationController@destroy');

Route::post('/product_type','ProductTypeController@store');
Route::patch('/product_type/{product_type}','ProductTypeController@update');
Route::delete('/product_type/{product_type}','ProductTypeController@destroy');

Route::post('/unit','UnitController@store');
Route::patch('/unit/{unit}','UnitController@update');
Route::delete('/unit/{unit}','UnitController@destroy');
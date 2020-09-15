<?php

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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/product','ProductController@index')->name('product.index');
// Route::namespace("Admin")->prefix('admin')->group(function(){
// 	Route::get('/', 'HomeController@index')->name('admin.index');
// 	Route::namespace('Auth')->group(function(){
// 		Route::get('/login', 'LoginController@showLoginForm')->name('admin.login');
// 		Route::post('/login', 'LoginController@login');
// 		Route::post('logout', 'LoginController@logout')->name('admin.logout');
// 	});
// });
Route::group(['middleware' => ['auth','isAdmin']], function () {
    Route::get('/dashboard',function(){
        return view('admin.index');
    });
});

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->middleware('verified');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

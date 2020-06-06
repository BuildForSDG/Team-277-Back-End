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


Route::group(['middleware'=>'api','prefix' => 'auth'], function($router){

    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::get('logout', 'AuthController@logout');
    Route::get('user', 'AuthController@getAuthUser');
   
});


Route::group(['middleware'=>'auth:api','prefix' => 'farm'], function($router){

    Route::get('/', 'FarmsController@index');
    Route::get('{id}', 'FarmsController@show');
    Route::post('create', 'FarmsController@store');
    Route::put('edit', 'FarmsController@update');
    Route::delete('delete', 'FarmsController@destroy');
   
});




Route::group(['middleware'=>'auth:api','prefix' => 'product'], function($router){

    Route::get('/', 'ProductsController@index');
    Route::get('{id}', 'ProductsController@show');
    Route::post('create', 'ProductsController@store');
    Route::put('edit', 'ProductsController@update');
    Route::delete('delete', 'ProductsController@destroy');
    
   
});
Route::get('products', 'ProductsController@products');
Route::post('products/search', 'ProductsController@searchProducts');
   


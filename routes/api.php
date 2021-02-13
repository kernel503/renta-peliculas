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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/categoria', 'Api\CategoryController@index');
Route::post('/categoria', 'Api\CategoryController@create');
Route::put('/categoria', 'Api\CategoryController@update');

Route::get('/pelicula', 'Api\MovieController@index');
Route::post('/pelicula', 'Api\MovieController@create');
Route::get('/pelicula/catalogo', 'Api\MovieController@catalogue');
Route::get('/pelicula/catalogo/{id}', 'Api\MovieController@record');
Route::post('/pelicula/compra', 'Api\MovieController@purchase');

Route::get('/usuarios', 'Api\PermissionController@index');
Route::put('/usuarios', 'Api\PermissionController@edit');

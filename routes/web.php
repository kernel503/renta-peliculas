<?php

use Illuminate\Support\Facades\Route;

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
    return redirect('/home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/tienda', 'MovieController@moviestore')->name('usuario-tienda');

Route::prefix('admin')->group(function () {
    Route::get('/categoria', 'CategoryController@index')->name('admin-categoria');
    Route::get('/pelicula', 'MovieController@index')->name('admin-pelicula');
});

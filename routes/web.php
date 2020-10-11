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
    return view('index');
});
Route::resource('product','ProductController');
Route::post('product/bulkdelete','ProductController@bulkdelete');
Route::resource('category','CategoryController');
Route::post('category/bulkdelete','CategoryController@bulkdelete');

Route::get('search','ProductController@searchProduct')->name('search');
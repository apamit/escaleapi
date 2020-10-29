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

// Route::namespace('Todo')->group(function () {
//     Route::prefix('todo')->group(function () {
//         Route::get('/', 'TodoController@show')->name('todo.show');
//         Route::post('create', 'TodoController@store')->name('todo.store');
//         Route::put('/update', 'TodoController@update')->name('todo.update');
//         Route::delete('/delete/{id}', 'TodoController@destroy')->name('todo.delete');
//     });
// });

Route::prefix('user')->group(function () {

    Route::namespace('User')->group(function () {
         Route::get('/', 'UserController@index')->name('user.index');
         Route::post('create', 'UserController@store')->name('user.create');
        //  Route::get('add', 'CategoryController@create')->name('category.add');
        //  Route::post('store', 'CategoryController@store')->name('category.store');
        //  Route::get('{id}', 'CategoryController@show')->name('category.show');
        //  Route::get('edit/{id}', 'CategoryController@edit')->name('category.edit');
        //  Route::post('update/{id}', 'CategoryController@update')->name('category.update');
        //  Route::get('delete/{id}', 'CategoryController@destroy')->name('category.destroy');
     });

 });

 Route::prefix('business')->group(function () {
    Route::namespace('Business')->group(function () {
         Route::get('/', 'BusinessController@index')->name('business.index');
         Route::post('create', 'BusinessController@store')->name('business.create');
     });
 });

 Route::prefix('product')->group(function () {
    Route::namespace('Product')->group(function () {
         Route::get('/', 'ProductController@index')->name('product.index');
         Route::post('create', 'ProductController@store')->name('product.create');
         Route::delete('{id}', 'ProductController@destroy')->name('product.destroy');
         Route::post('{id}', 'ProductController@update')->name('product.update');
     });
 });

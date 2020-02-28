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

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/', 'HomeController@index');
    Route::get('/gifts', 'GiftController@index');
    Route::post('/gifts/assign/{id}', 'GiftController@assign');
    Route::post('/gifts/unassign/{id}', 'GiftController@unassign');
});

Route::middleware('admin')->prefix('admin')->group(function () {
    Route::get('/', function () {
        return view('admin/home');
    });
    Route::get('/gifts', 'GiftController@index');
    Route::post('/gifts', 'GiftController@store');
    Route::delete('/gifts/{id}', 'GiftController@destroy');
    Route::put('/gifts/{id}', 'GiftController@update');
    Route::post('/gifts/unassign/{id}', 'GiftController@unassign');
});

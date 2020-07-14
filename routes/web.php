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

Route::get('/', 'GuideController@index')->name('guide.index');

Route::view('login', 'login');
Route::post('login', 'UserController@postLogin')->name('postLogin');

Route::group(['prefix' => 'user'], function(){
    Route::get('/list', 'UserController@list');
})->middleware('can:list');
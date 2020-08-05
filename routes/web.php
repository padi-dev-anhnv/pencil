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

Route::get('/', 'GuideController@homepage');

Route::get('login', 'UserController@login')->name('login');
Route::get('logout', 'UserController@logout')->name('logout');
Route::post('login', 'UserController@postLogin')->name('postLogin');

Route::group(['prefix' => 'user', 'middleware' =>['can:list,\App\User', 'active_user'] ], function(){
    Route::view('/', 'pages.user.index')->name('user');
    Route::post('/', 'UserController@create');
    Route::get('/{id}/show', 'UserController@show');
    Route::view('/{id}/edit', 'pages.user.edit');
    Route::view('/create', 'pages.user.new')->name('user.new');
    Route::get('/get-list', 'UserController@list');
    Route::post('/delete', 'UserController@delete');
    Route::get('/roles', 'UserController@getRoles');
    Route::get('/user-per-file', 'UserController@listUserPerFile');

});
Route::group(['prefix' => 'file', 'middleware' =>['can:list,\App\File', 'active_user'] ], function(){
    Route::view('/', 'pages.file.index')->name('file');    
    Route::post('/', 'FileController@create');
    Route::post('/upload', 'FileController@upload');
    Route::get('/search', 'FileController@search');
    Route::get('/{id}/show', 'FileController@show');    
    Route::get('/{id}/download', 'FileController@download');    
});

Route::group(['prefix' => 'guide', 'middleware' =>['auth', 'active_user'] ], function(){
    Route::get('/', 'GuideController@index')->name('guide');
    Route::post('/', 'GuideController@create');
    Route::view('/{id}/edit', 'pages.guide.edit')->name('guide.edit');
    Route::get('/{id}/get-guide', 'GuideController@getGuide');
    Route::view('/create', 'pages.guide.new')->middleware('can:create,\App\Guide')->name('guide.create'); 
    Route::get('/listSuppliers', 'GuideController@listSuppliers');
    Route::get('/search', 'GuideController@search');    
    Route::get('/workers', 'UserController@getWorkers');    
    Route::get('/offices', 'UserController@getOffices');
    Route::post('/delete', 'GuideController@delete');
    Route::post('/clone', 'GuideController@clone');
});

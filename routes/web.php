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
    Route::post('/upload-customer-csv', 'CustomerController@uploadCustomer');
});

Route::group(['prefix' => 'file', 'middleware' =>['active_user'] ], function(){
    Route::middleware(['can:list,\App\File'])->group(function () {
        Route::view('/', 'pages.file.index')->name('file');    
        Route::post('/', 'FileController@create');
        Route::post('/upload', 'FileController@upload');
        Route::post('/upload-multi', 'FileController@upload_multi');
        Route::get('/search', 'FileController@search');
        Route::post('/delete', 'FileController@delete');
        Route::get('/user-per-file', 'UserController@listUserPerFile');
    });    
    // Route::middleware(['can:view,\App\File'])->group(function () {
        Route::get('/{id}/show', 'FileController@show');    
        Route::get('/{id}/download', 'FileController@download');
    // });
});

Route::group(['prefix' => 'guide', 'middleware' =>['can:list,\App\Guide', 'active_user'] ], function(){
    Route::get('/', 'GuideController@index')->name('guide');
    Route::post('/', 'GuideController@create');
    Route::post('/update-product', 'GuideController@updateProduct');
    Route::get('/{id}/edit', 'GuideController@edit')->name('guide.edit');
    Route::view('/{id}/dupplicate', 'pages.guide.dupplicate')->middleware('can:create,\App\Guide')->name('guide.dupplicate');
    Route::get('/{id}/get-guide', 'GuideController@getGuide');
    Route::view('/create', 'pages.guide.new')->middleware('can:create,\App\Guide')->name('guide.create'); 
    Route::get('/listSuppliers', 'GuideController@listSuppliers');
    Route::get('/search', 'GuideController@search');    
    Route::get('/workers', 'UserController@getWorkers');    
    Route::get('/offices', 'UserController@getOffices');
    Route::post('/delete', 'GuideController@delete');
    Route::post('/clone', 'GuideController@clone');
    Route::post('/change-export', 'GuideController@changeExport');
    Route::get('/find-customer', 'CustomerController@findCustomer');
    Route::get('/{id}/show/{price}', 'GuideController@showPdf')->name('guide.show');
    
});

Route::get('/{id}/show-html/{price}', 'GuideController@showPdfHtml')->name('guide.html');

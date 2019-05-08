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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
	Route::group(['prefix' => 'book'], function() {
		Route::get('get-data', 'BookController@getData');
		Route::post('import', 'BookController@import');
		Route::get('download-template', 'BookController@downloadTemplate');
	});

	Route::resource('book', 'BookController');
});
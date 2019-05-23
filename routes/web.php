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
		Route::get('get-chart', 'BookController@getChart');
		Route::post('import', 'BookController@import');
		Route::get('download-template', 'BookController@downloadTemplate');
	});

	Route::group(['prefix' => 'category'], function() {
		Route::get('get-datatables', 'CategoryController@getDatatables');
		Route::get('get-chart', 'CategoryController@getChart');
	});

	Route::apiResource('book', 'BookController');
	Route::apiResource('category', 'CategoryController');
});
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
	Route::group(['prefix' => 'sale'], function() {
		Route::get('get-data', 'SaleController@getData');
		Route::get('get-chart', 'SaleController@getChart');
		Route::post('import', 'SaleController@import');
		Route::get('download-template-xlsx', 'SaleController@downloadTemplateXlsx');
	});

	Route::apiResource('sale', 'SaleController');
});
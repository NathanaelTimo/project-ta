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
		Route::get('/get-data', 'SaleController@getData');
		Route::post('/import', 'SaleController@import');
		Route::get('/download-template-xlsx', 'SaleController@downloadTemplateXlsx');
	});

	Route::group(['prefix' => 'statistic'], function() {
		Route::get('/get-chart', 'HomeController@getChart');
		Route::get('/get-top-item', 'HomeController@getTopItem');
		Route::get('/get-top-customer', 'HomeController@getTopCustomer');
	});

	Route::apiResource('sale', 'SaleController');
});
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

Route::get('/', 'HomeController@index')->name('index');

Route::post('/submit', 'HomeController@submit');

Route::get('/get-customers', 'ShopifyController@getCustomers');

Route::get('/free-places/{id}', 'HomeController@getFreePlaces');

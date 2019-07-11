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

Route::get('/test/{any}', 'Api\TestController@index')->where('any', '.*');
Route::get('/{any}', 'Api\AppController@index')->where('any', '.*');

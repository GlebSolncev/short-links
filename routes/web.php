<?php

use Illuminate\Support\Facades\Route;

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

Route::group(['namespace' => 'Site'], function(){
    Route::group(['as' => 'short-link.', 'prefix' => 'short-link'], function(){
        Route::get('', 'ShortLinkController@index')->name('index');
        Route::post('', 'ShortLinkController@store')->name('store');
        Route::put('{endpoint}', 'ShortLinkController@update')->name('update');
        Route::delete('{endpoint}', 'ShortLinkController@destroy')->name('destroy');
    });

    Route::get('{endpoint}', 'ShortLinkController@show')->name('short-link.show');

});
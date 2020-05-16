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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function() {
    Route::group(['prefix' => '/fund'], function() {
        Route::post('/inline', 'FundController@postPaystack')->name('paystack.post');
        Route::post('/standard', 'FundController@redirectToGateway')->name('paystack.standard');
        Route::get('/callback', 'FundController@handleGatewayCallback')->name('paystack.callback');
    });
});

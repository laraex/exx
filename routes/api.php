<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::post('login', 'Api\UserController@login');
Route::post('register', 'Api\UserController@register');
Route::get('/viewprofile', 'Api\UserProfileController@view')->middleware('auth:api');
Route::get('wallet', 'Api\WalletController@index')->middleware('auth:api'); 
Route::get('/fund/list/{status}/{id}', 'Api\FundController@fundList')->middleware('auth:api');
Route::get('/withdraw/{status}/{paymentid}', 'Api\WithdrawController@index')->middleware('auth:api');
Route::get('/fundtransfer/type/{type}/{currency_id}', 'Api\FundTransferController@index')->middleware('auth:api');
Route::get('/transaction/fiatcurrency', 'Api\TransactionController@fiatCurrencyTransaction')->middleware('auth:api');
Route::get('/transaction/buycoin', 'Api\TransactionController@buyCoinTransaction')->middleware('auth:api');
Route::get('/transaction/sendcoin', 'Api\TransactionController@sendCoinTransaction')->middleware('auth:api');
Route::get('/transactions', 'Api\TransactionController@transactionDetails')->middleware('auth:api');

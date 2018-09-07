<?php

use App\TradeCurrencyPair;
use Illuminate\Support\Facades\Route;
include_once 'translations.php';

Route::post('/bitcoind/transactionnotify/', 'BitcoindWalletNotifyController@transaction_bitcoin');

Route::post('/blockio/transactionnotify/', 'BitcoindWalletNotifyController@transaction_blockio');

Route::post('/litecoind/transactionnotify/', 'LitecoindWalletNotifyController@transaction_litecoin');
Route::post('/bitcoincashd/transactionnotify/', 'BitcoincashdWalletNotifyController@transaction_bitcoincash');

Route::post('/qtumd/transactionnotify/', 'QtumdWalletNotifyController@transaction_qtum');

Route::get('/vuelivefeed', function () {
	return view('vuelivefeed');
});
Route::get('/setlocale/{locale}', 'LanguageController@index');
Route::get('/', 'WelcomeController@indexRedirect');
Route::get('/trade/{cpair}', 'WelcomeController@index');
Route::get('/tradecurrencylist', function () {
	return App\TradeCurrencyPair::where('status', 'active')->orderBy('from_currency_id', 'ASC')->get();
});
Route::get('/trade/totaltrade', 'Myaccount\TradeContentController@show');

Route::get('/exchangerate/getrates/{pair}', 'ExchangeRateController@getRates');

Route::get('/exchangerate/bitfinex/{pair}', 'ExchangeRateController@getBitfinex');
Route::get('/exchangerate/kraken/{pair}', 'ExchangeRateController@getKraken');
Route::get('/exchangerate/coinmarketcap/{pair}', 'ExchangeRateController@getCoinmarketcap');
Route::get('/exchangerate/bitflyer/{pair}', 'ExchangeRateController@getBitflyer');

Route::get('/trade/curltest/{pair}', 'Myaccount\TradeContentController@testcurl');

Route::get('curinfor/{pair}', 'Myaccount\TradeContentController@currencyInfor');
//Buy Exchange

// Route::get('/marketrate', function () {
//     return new CurrencyPairCollection(TradeCurrencyPair::all());
// });

Route::get('/marketrate', 'TradeMarketDataController@index');
Route::get('/pairmarketrate', 'TradeMarketDataController@pairmarketrate');
Route::get('/pair', 'TradeMarketDataController@getPair');
Route::get('/trade/tradestats/{pairid}', 'TradeMarketDataController@stats');
Route::get('/getorder/{pairid}', 'TradeMarketDataController@getOrder');
Route::get('/currencydetail/{curid}', 'TradeMarketDataController@currencyDetails');

Route::get('/checkxrp', 'TradeMarketDataController@checkXRP');

//Route::get('/charts', 'PageController@chart');
//Route::get('/market', 'PageController@market');
Route::post('/favourite', 'UserController@favourite');

Route::get('/refreshcontent', 'WelcomeController@refreshcontent');
Route::get('/livefeed', 'LiveFeedController@livefeed');
Route::get('/livefeedtest', 'LiveFeedController@index');
Route::get('/livefeeds', 'LiveFeedController@completelivefeedview');
Route::get('/ref/{referrer}', 'WelcomeController@refferal');
//sowmi
Route::get('/getpairdetails/{name}', 'TickerController@getpairdeatils');
//Market
Route::get('/market', 'MarketController@index');
// For Chart
Route::post('/chart/', 'ChartController@chart');
Route::get('/chart/', 'ChartController@chart');
Route::get('/livechart', 'ChartController@index');
//Trade
//Route::get('/trade', 'Myaccount\TradeController@index');

Route::get('/trade/gettrade/{id}', 'Myaccount\TradeController@show');
Route::get('/trade/gettradedata/{id}', 'Myaccount\TradeController@showuserOrder');


Route::get('/tradedetails/{id}', 'Myaccount\TradeController@showDetails');
Route::get('/buy/exchangerates', 'Myaccount\BuyController@exchangerates');

//Bitcoind
Route::get('/bitcoind/getblock/', 'BitcoinController@blockInfo');
Route::get('/bitcoind/getbalance/{account}', 'BitcoinController@balance');
Route::get('/bitcoind/getaccountaddress/{account}', 'BitcoinController@accountaddress');
Route::get('/bitcoind/listaccounts/', 'BitcoinController@getlistaccounts');
Route::get('/bitcoind/sendfrom/', 'BitcoinController@send');
Route::get('/bitcoind/gettransaction/{txnhash}', 'BitcoinController@transaction');
Route::get('/bitcoind/getaddressesbyaccount/{account}', 'BitcoinController@addressesbyaccount');
Route::get('/bitcoind/listtransactions/{account}', 'BitcoinController@getlisttransactions');
Route::get('/bitcoind/getaccount/{address}', 'BitcoinController@getaccountbyaddress');
Route::get('/bitcoind/getreceivedbyaccount/{account}', 'BitcoinController@receivedbyaccount');
Route::get('/bitcoind/listreceivedbyaccount/{account}', 'BitcoinController@getlistreceivedbyaccount');

//Litecoind
Route::get('/litecoind/getblock/', 'LitecoinController@blockInfo');
Route::get('/litecoind/getbalance/{account}', 'LitecoinController@balance');
Route::get('/litecoind/getaccountaddress/{account}', 'LitecoinController@accountaddress');
Route::get('/litecoind/listaccounts/', 'LitecoinController@getlistaccounts');
Route::get('/litecoind/sendfrom/', 'LitecoinController@send');
Route::get('/litecoind/gettransaction/{txnhash}', 'LitecoinController@transaction');
Route::get('/litecoind/getaddressesbyaccount/{account}', 'LitecoinController@addressesbyaccount');
Route::get('/litecoind/listtransactions/{account}', 'LitecoinController@getlisttransactions');
Route::get('/litecoind/getaccount/{address}', 'LitecoinController@getaccountbyaddress');
//Ethereum
Route::get('/ethereum/createaddress/{eth_passphrase}', 'ETHController@createaddress');
Route::get('/ethereum/protocolversion/', 'ETHController@protocolVersion');
Route::get('/ethereum/accounts/', 'ETHController@accounts');
Route::get('/ethereum/balance/{address}', 'ETHController@getBalance');
Route::get('/ethereum/transactionbyhash/{hash}', 'ETHController@getTransactionByHash');
Route::get('/ethereum/transactionreceiptbyhash/{hash}', 'ETHController@getTransactionReceipt');
Route::get('/ethereum/sendTransaction/{from}/{to}/{amount}', 'ETHController@sendTransaction');
Route::get('/ethereum/gasPrice', 'ETHController@gasPrice');

//Bitcoincashd
// Route::get('/bitcoincashd/getblock/', 'BitcoincashController@blockInfo');
Route::get('/bitcoincashd/getbalance/{account}', 'BitcoincashController@balance');
Route::get('/bitcoincashd/getaccountaddress/{account}', 'BitcoincashController@accountaddress');
Route::get('/bitcoincashd/listaccounts/', 'BitcoincashController@getlistaccounts');
Route::get('/bitcoincashd/sendfrom/', 'BitcoincashController@send');
// Route::get('/bitcoincashd/gettransaction/{txnhash}', 'BitcoincashController@transaction');
Route::get('/bitcoincashd/getaddressesbyaccount/{account}', 'BitcoincashController@addressesbyaccount');
// Route::get('/bitcoincashd/listtransactions/{account}', 'BitcoincashController@getlisttransactions');

Route::get('/bitcoincashd/getaccount/{address}', 'BitcoincashController@getaccountbyaddress');
Route::get('/trade/{status}/{pair}', 'Myaccount\TradeController@showTrade');

// Guest
Route::group(['middleware' => 'guest'], function () {
	Route::get('/admin', function () {
		return redirect('/admin/login');
	});
	Route::get('/admin/login', 'Admin\LoginController@showAdminLoginForm');
	Route::post('admin/login', 'Admin\LoginController@login');

	Route::get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
	Route::post('/password/reset', 'Auth\ResetPasswordController@reset');
	Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
	Route::post('/password/reset/{token}', 'Auth\ResetPasswordController@reset');
	Route::post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');

	// Route::group(['middleware' => 'guest'], function () {
	//     Route::get('/admin/login', 'Admin\LoginController@showAdminLoginForm');
	//     Route::post('admin/login', 'Admin\LoginController@login');
	// });

	//for staff
	Route::get('/staff', function () {
		return redirect('/staff/login');
	});
	Route::get('/staff/login', 'Staff\LoginController@showStaffLoginForm');
	Route::post('staff/login', 'Staff\LoginController@login');
	Route::get('/admin/login', 'Admin\LoginController@showAdminLoginForm');
	Route::post('admin/login', 'Admin\LoginController@login');
});

// Admin
Route::group([
	'prefix' => 'admin',
	'middleware' => ['auth', 'admin1', 'otp'],
	'namespace' => 'Admin',
], function () {
	// CRUD resources and other admin routes
	Route::get('/dashboard', 'DashboardController@index');
	CRUD::resource('monster', 'MonsterCrudController');
	CRUD::resource('pages', 'PageCrudController');
	CRUD::resource('faqs', 'FaqCrudController');
	CRUD::resource('currency', 'CurrencyCrudController');
	CRUD::resource('paymentgateway', 'PaymentgatewayCrudController');
	CRUD::resource('sliders', 'SliderCrudController');
	CRUD::resource('erc20token', 'ERC20TokenCrudController');

	Route::get('/activitylogs', 'ActivitylogController@index');
	Route::post('/activitylogs', 'ActivitylogController@index');

	Route::get('/changepassword', 'ChangePasswordController@index');
	Route::post('/changepassword', 'ChangePasswordController@updatepassword');
	Route::get('/users', 'UserController@index');
	Route::post('/users', 'UserController@index');
	Route::get('/users/{id}', 'UserController@show');
	Route::post('/users/verifykyc/{id}', 'UserController@verifykyc');
	Route::post('/users/rejectkyc/{id}', 'UserController@rejectkyc');
	Route::get('/users/create/new', 'UserController@create');
	Route::post('/users/create/new', 'UserController@store');
	Route::get('/staffs', 'UserController@stafflist');
	Route::get('/users/resetpassword/{id}', 'UserController@resetpassword');
//sowmi
	Route::get('/users/resettransactionpassword/{id}', 'UserController@resettransactionpassword');
	Route::get('/users/resend/{id}', 'UserController@resendverification');
	Route::post('/users/destroy/{id}', 'UserController@destroy');
	Route::get('/users/sendmsg/{user_id}', 'UserController@create_msg');
	Route::post('/users/sendmsg', 'UserController@store_msg');
	Route::get('/users/balance/{id}', 'UserController@balance');
	Route::get('/users/sendmail/{user_id}', 'UserController@create_mail');
	Route::post('/users/sendmail', 'UserController@store_mail');
	//Route::get('/users/{id}/wallet','UserController@wallet');
	Route::get('users/disable/{id}', 'UserController@disableTwoFactor');
	CRUD::resource('setting', 'SettingCrudController');

	CRUD::resource('mailtemplate', 'MailtemplateCrudController');
	

	Route::get('/usergroup/list', 'MemberGroupController@index');
	Route::get('/usergroup/create', 'MemberGroupController@create');
	Route::post('/usergroup/create', 'MemberGroupController@store');
	Route::get('/usergroup/edit/{id}', 'MemberGroupController@edit');
	Route::post('/usergroup/edit/{id}', 'MemberGroupController@update');
	Route::get('/usergroup/allusers/{id}', 'MemberGroupController@all_users');
	Route::get('/usergroup/rules/{id}', 'MemberGroupController@show_rules');
	Route::get('/usergroup/delete/{id}', 'MemberGroupController@destroy');

	Route::post('/users/update/{id}', 'UserController@update');
	Route::get('/actions/{name}', 'ActionController@index');
	
	CRUD::resource('news', 'NewsCrudController');
	CRUD::resource('ticketstatus', 'Ticket_statusCrudController');
	CRUD::resource('ticketpriority', 'Ticket_prioritiesCrudController');
	CRUD::resource('ticketcategory', 'Ticket_categoriesCrudController');
	CRUD::resource('ticketcategoryuser', 'Ticket_categories_usersCrudController');

	Route::get('/ticket', 'TicketsController@index');
	Route::get('/ticket/{id}', 'TicketsController@show');
	Route::post('/ticket/storecomment', 'TicketsController@storecomment');
	Route::get('/ticket/update/{statusid}/{id}', 'TicketsController@update');
	Route::get('/ticket/download/{id}', 'TicketsController@download');
	Route::get('/depositfund/confirm/{id}', 'FundController@depositfundconfirm');
	Route::post('/depositfund/approve/{id}', 'FundController@depositfundapprove');
	Route::get('/depositfund/reject/{id}', 'FundController@depositfundreject');

	Route::get('/fund/active', 'FundController@activedepositfund');

	Route::get('/withdraw/{status}', 'WithdrawController@index');
	Route::get('/withdraw/complete/{id}', 'WithdrawController@complete');
	Route::post('/withdraw/complete/{id}', 'WithdrawController@updatecomplete');
	Route::get('/withdraw/reject/{id}', 'WithdrawController@reject');
	Route::post('/withdraw/reject/{id}', 'WithdrawController@updatereject');

	Route::get('/fundtransfer', 'FundtransferController@index');

	Route::get('/message/send', 'MessageController@create');
	Route::post('/message/save', 'MessageController@store');
	Route::get('/message/list', 'MessageController@index');
	Route::get('/message/conversation/{conversationid}', 'MessageController@conversation');
	Route::post('/message/conversation/save/{conversationid}', 'MessageController@conversationsave');
	Route::post('/quickmessage', 'MessageController@quickmessage');

	Route::get('/exchange/lists', 'ExchangeController@index');

	Route::get('/earnings', 'EarningsController@index');
	Route::post('/earnings', 'EarningsController@index');

	

	CRUD::resource('referralgroups', 'ReferralgroupCrudController');

	Route::get('/currencypair', 'CurrencyPairController@index');
	Route::get('/currencypair/edit/{id}', 'CurrencyPairController@edit');
	Route::post('/currencypair/edit/{id}', 'CurrencyPairController@update');

	Route::get('/exchange/show', 'TransactionController@index_fiat');
	Route::get('/externalexchange/show', 'TransactionController@index_crypto');
	Route::get('/buycoin/show', 'TransactionController@index_buycoin');

	Route::get('/externalexchangefee', 'FeeController@index');
	Route::post('/externalexchangefee', 'FeeController@index');
	//KYC
	Route::get('/kyc/', 'KYCController@index');
	Route::get('/kyc/approved/{id}', 'KYCController@kyc_approved');
	Route::post('/users/proofdownload/kyc/{proof}/{id}', 'KYCController@proofDownload');
	Route::get('/users/verify/kyc/{proof}/{id}', 'KYCController@verify');
	Route::get('/users/reject/kyc/{proof}/{id}', 'KYCController@reject');

	//Quick Message
	Route::get('/searchuser', 'UserController@searchuser');

	Route::get('/create', 'AdminController@create');
	Route::post('/create', 'AdminController@store');
	Route::get('/show', 'AdminController@show');

	Route::get('/loggedin', 'LoggedInController@index');
//sowmi
	CRUD::resource('blockedusername', 'BlockedusernameCrudController');
	CRUD::resource('/country', 'CountryCrudController');
	CRUD::resource('/sociallink', 'SociallinkCrudController');

	Route::get('/sendmail', 'SendMailController@index');
	Route::post('/sendmail/search', 'SendMailController@index');
	Route::get('/sendmail/{user_id}', 'SendMailController@create');
	Route::post('/sendmail', 'SendMailController@store');
	Route::get('/viewmessage/{id}', 'SendMailController@viewmessage');
//sowmi
	Route::get('/massmail', 'SendMailController@create_massmail');
	Route::post('/massmail', 'SendMailController@store_massmail');

	Route::get('/exportusers', 'ExportController@exportUsers');
	Route::get('/exportmember', 'ExportController@exportMember');
	Route::get('/exportcrypto', 'ExportController@exportCryptoExchangeFee');
	Route::get('/exportfund', 'ExportController@exportFund');
	Route::get('/exportfundtrans', 'ExportController@exportfundtransfer');
	Route::get('/exportexchange', 'ExportController@exportexchange');
	Route::get('/exportsendmail', 'ExportController@exportsendmaillist');
	Route::get('/exportadminearnings', 'ExportController@exportearnings');
	Route::get('/exportactivitylogs', 'ExportController@exportactivitylogs');
	Route::get('/sellcoin/show', 'TransactionController@index_sellcoin');

	Route::get('/memberbalance', 'MemberBalanceController@index');
	Route::post('/memberbalance', 'MemberBalanceController@index');

	//Route::get('/memberbalancenew', 'MemberBalanceController@show');
	//Fiat Currency
	Route::get('/getcurrency/{id}', 'DashboardController@getCurrency');
	Route::get('/getcurrencytoken/{currency_id}', 'DashboardController@getCurrencyToken');
//Crypto Currency
    Route::get('/getcryptocurrency/{id}', 'DashboardController@getcryptocurrency');
    //Route::get('/getcryptocurrencytoken/{}')
    Route::get('/tradeorder/open', 'TradeController@open');
    Route::get('/tradeorder/closed', 'TradeController@closed');
    Route::get('/tradeorder/settlements', 'TradeController@settlements');
    Route::get('/exportwallet/{id}', 'ExportController@exportWallet');
    Route::get('/exportmemberwallet', 'ExportController@exportMemberWallet');
    Route::get('/cashpointbalance', 'CashPointBalanceController@index');
    Route::get('/exportmemberxls/{id}', 'ExportController@exportWalletXLS');
    Route::get('/exportallmemberxls', 'ExportController@exportAllMemberWallet');
    Route::get('/exportusersxls', 'ExportController@exportUsersxls');
     Route::get('/cryptowithdraw/pending', 'CryptoWithdrawController@index_pending');
     Route::get('/cryptowithdraw/approve', 'CryptoWithdrawController@index_approve');
     Route::get('/cryptowithdraw/cancel', 'CryptoWithdrawController@index_cancel');
     Route::get('/cryptowithdraw/approve/{id}', 'CryptoWithdrawController@show_approve');
     Route::post('/cryptowithdraw/approve/{id}', 'CryptoWithdrawController@store_approve');
       Route::get('/cryptowithdraw/cancel/{id}', 'CryptoWithdrawController@show_cancel');
     Route::post('/cryptowithdraw/cancel/{id}', 'CryptoWithdrawController@store_cancel');
});

Auth::routes();

//For OTP
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'admin1']], function () {
	Route::get('/generateotp/', 'OTPController@generateotp');
	Route::post('/verifyotp', 'OTPController@verifyotp');
});

Route::get('/myaccount/logout', 'Auth\LoginController@logout');
Route::post('/myaccount/logout', 'Auth\LoginController@logout');

// User
Route::group([
	'prefix' => 'myaccount',
	'middleware' => ['auth'],
	'namespace' => 'Myaccount',
], function () {

	//sowmi
	Route::get('/investment', 'KYCController@create_investment');
	Route::post('/investment', 'KYCController@store_investment');


	// Route::get('/home', 'HomeController@index')->name('home');

	// Add 2FA validation when edit the profile
	Route::get('/profile/validate2fa', 'UserprofileController@index')->name('profile');
	Route::post('/profile/validate2fa', 'UserprofileController@validate2fa')->name('profile');

	Route::get('/profile', 'UserprofileController@create')->name('profile');
	Route::get('/viewprofile', 'UserprofileController@view')->name('profile');
	Route::post('/profile', 'UserprofileController@update')->name('profile');
	Route::get('/changepassword', 'UserprofileController@change_password')->name('profile');
	Route::post('/update_change_password', 'UserprofileController@update_change_password')->name('profile');

	Route::post('/getmobilecode', 'UserprofileController@getmobilecode')->name('profile');

	Route::get('/transactionpassword', 'UserprofileController@transaction_password')->name('profile');
	Route::post('/update_transaction_password', 'UserprofileController@update_transaction_password')->name('profile');
	Route::get('/rest_transaction_password', 'UserprofileController@change_transaction_password')->name('profile');
	Route::post('/notification', 'NotificationController@markasread');

	Route::get('/changeavatar', 'UserprofileController@changeavatar')->name('profile');
	Route::post('/saveavatar', 'UserprofileController@saveavatar')->name('profile');

	//Route::get('/tools', 'ToolsController@index');
	Route::get('/support', 'TicketsController@support');
	Route::get('/ticket', 'TicketsController@index');
	Route::get('/ticket/create', 'TicketsController@create');
	Route::post('/ticket/store', 'TicketsController@store');
	Route::get('/ticket/{id}', 'TicketsController@show');
	Route::post('/ticket/storecomment', 'TicketsController@storecomment');
	Route::get('/ticket/update/{statusid}/{id}', 'TicketsController@update');
	Route::get('/ticket/download/{id}/{ticketid}', 'TicketsController@download');

	Route::get('/getcurrency', 'ExchangeController@getCurrencyNew');

	Route::get('/accounts/{currency}', 'ExchangeController@accounts')->name('accounts');
	Route::get('/accounts/create', 'ExchangeController@create')->name('exchange');
	Route::get('/exchange', 'ExchangeController@exchange')->name('exchange');
	
	Route::post('/exchange/changecurrencyvalue', 'ExchangeController@changecurrencyvalue')->name('exchange');

	Route::get('/addfundcurrency/{currency}', 'FundController@addfundcurrency');
	Route::get('/addfund', 'FundController@create')->name('addfund');
	Route::post('/addfund', 'FundController@store')->name('addfund');
	Route::post('/addfund/bankwire', 'FundController@savebankwire');
	Route::get('/fund/bitcoindirect', 'FundController@bitcoindirect');
	Route::post('/fund/bitcoindirect', 'FundController@savebitcoindirect');
	Route::get('/fund/list/{status}/{currencyid}', 'FundController@fundlist');
    Route::get('/bankwire/printinvoice', 'FundController@printinvoice');
	Route::get('/bankwire/invoice/{depositid}', 'FundController@invoice');

	//Route::get('/viewpayaccounts', 'UserpayaccountsController@index')->name('mypayaccounts');

	Route::get('/getpayaccountlist/{id}', 'UserpayaccountsController@getPayaccount');

	//sowmi
	Route::get('/viewbankdetails/{id}', 'UserpayaccountsController@bank_details');

	Route::get('/payaccounts/{id}', 'UserpayaccountsController@create');
	Route::post('/payaccounts', 'UserpayaccountsController@store');

	Route::get('/activeaccounts/{id}/{paymentid}/{status}', 'UserpayaccountsController@activeaccounts');
	Route::get('/currentaccounts/{id}/{paymentid}/{status}', 'UserpayaccountsController@currentaccounts');
	Route::post('/removeaccount/{id}', 'UserpayaccountsController@removeaccount');
	Route::get('/withdraw/{status}', 'WithdrawController@index');
	Route::get('/withdraw', 'WithdrawController@create');
	Route::post('/withdraw', 'WithdrawController@store');
	Route::post('/withdraw/usebuyxrp', 'WithdrawController@savexrpBuy');

	Route::post('/withdraw/userpayaccount', 'WithdrawController@userpayaccount');

	Route::get('/withdraw/viewbitcoinwallet/{id}', 'WithdrawController@viewbitcoinwallet');

	Route::get('/withdraw/redirectform/{paymentgatewayid}', 'WithdrawController@redirectform');
	Route::get('/fundtransfer/redirectform/{currencyid}', 'FundTransferController@redirectform');
	Route::get('/fundtransfer/type/{type}', 'FundTransferController@index');
	Route::get('/fundtransfer/send', 'FundTransferController@create');
	Route::post('/fundtransfer/store', 'FundTransferController@store');
	Route::get('/fundtransfer/searchuser', 'FundTransferController@searchuser');
	Route::get('/message/send', 'MessageController@create');
	Route::post('/message/save', 'MessageController@store');
	Route::get('/message/list', 'MessageController@index');
	Route::get('/message/conversation/{conversationid}', 'MessageController@conversation');
	Route::post('/message/conversation/save/{conversationid}', 'MessageController@conversationsave');
	//Test
	//Route::get('/tradehistory/show/{status}', 'TradeController@showorder');
	Route::get('/tradehistory/show/{status}/{id}', 'TradeController@showorder');
	Route::get('/cancelorder/{id}', 'TradeController@cancelOrder');

	Route::get('/cancelorders/{id}', 'TradeController@cancelOrders');

	Route::get('/transhistory/{id}', 'TradeController@showHistory');
	Route::get('/transhistory/all/{id}', 'TradeController@showAllHistory');
	//Route::get('/orderhistory/trade/{status}', 'OrderHistoryController@giftcard');

	Route::get('/viewpayaccounts/type/{coinname}', 'UserpayaccountsController@create_wallet');
	Route::post('/viewpayaccounts/type/{coinname}', 'UserpayaccountsController@store_wallet');
	Route::post('/getwalletaddress/', 'HomeController@getwalletaddress');
	Route::get('/type/btc/send', 'CoinController@send_create');
	Route::get('/type/btc/receive', 'CoinController@receive_create');
	Route::post('/type/btc/send', 'CoinController@send_store');
	// Route::post('/type/btc/send', 'BTCController@store');
	Route::get('/type/ltc/send', 'CoinController@ltc_send_create');
	Route::get('/type/ltc/receive', 'CoinController@ltc_receive_create');
	Route::post('/type/ltc/send', 'CoinController@ltc_send_store');
	Route::get('/type/doge/send', 'CoinController@doge_send_create');
	Route::get('/type/doge/receive', 'CoinController@doge_receive_create');
	Route::post('/type/doge/send', 'CoinController@doge_send_store');
	Route::get('/type/bch/receive', 'CoinController@bch_receive_create');
	Route::get('/type/bch/send', 'CoinController@bch_send_create');
	Route::post('/type/bch/send', 'CoinController@bch_send_store');
	//ETH SEND
	Route::get('/type/eth/receive', 'CoinController@eth_receive_create');
	Route::get('/type/eth/send', 'CoinController@eth_send_create');
	Route::post('/type/eth/send', 'CoinController@eth_send_store');

	//QTUM Send 
	Route::post('/type/qtum/send', 'CoinController@send_qtumstore');

	//Ripple Send 
	Route::post('/type/xrp/send', 'CoinController@send_xrpstore');

	//withdraw
	Route::post('/send/withdraw', 'CoinController@send_withdrawstore');
	//sowmi
	Route::get('/transfer/show', 'CoinController@show');
	Route::get('externalexchange/pair/{id}', 'ExternalExchangeController@setpair');
	Route::get('externalexchange/create', 'ExternalExchangeController@create');
	Route::post('externalexchange/create', 'ExternalExchangeController@store');
	Route::post('externalexchange/getexchange', 'ExternalExchangeController@getexchange');
	Route::post('externalexchange/confirm', 'ExternalExchangeController@confirm');
	Route::get('externalexchange/show', 'ExternalExchangeController@show');
	Route::get('/getwallet', 'ExternalExchangeController@getWalletDetails');
	Route::get('/exchange/show', 'ExchangeController@show');
	//Coin
	Route::get('/buy/setcoin/{currency}', 'BuyController@setcoin');
	Route::get('/buycoin', 'BuyController@create');
	Route::post('/buy/exchangerate', 'BuyController@exchangerate');
	//Route::post('/buy/exchangerates', 'BuyController@exchangerates');
	Route::post('/buycoin', 'BuyController@store');
	Route::get('/buycoin/confirm', 'BuyController@confirm_create');
	Route::post('/buycoin/confirm', 'BuyController@confirm');
	Route::get('/buycoin/show', 'BuyController@show');
	//Trade
	//Route::get('/trade', 'TradeController@index');
	Route::post('trade/buy/check', 'TradeBuyController@checkbuy');
	Route::post('/trade/buy', 'TradeBuyController@store');
	Route::post('/trade/sell/check', 'TradeSellController@checksell');
	Route::post('/trade/sell', 'TradeSellController@store');
	Route::post('trade/getbuyexchange', 'BuyController@getbuyexchange');
	Route::post('trade/getsellexchange', 'BuyController@getsellexchange');
	//Route::post('/trade/totaltrade', 'TradeContentController@show');
	//Buy Exchange
	Route::get('/getbuyexchange', 'TradeController@getBuyExchange');
	Route::post('/getsellexchange', 'TradeController@getSellExchange');
	//Buy Exchange
	//Trade
	// Two factor authentication
	Route::get('/twofactor', 'Google2FAController@twofactor');
	Route::get('/2fa/enable', 'Google2FAController@enableTwoFactor');
	Route::get('/2fa/disable', 'Google2FAController@disableTwoFactor');
	Route::get('/2fa/validate', 'Google2FAController@getValidateToken');
	Route::post('/2fa/validate', 'Google2FAController@postValidateToken');
	//KYC
	Route::get('/kyc', 'KYCController@create');
	Route::post('/kyc', 'KYCController@store');
	Route::get('/financial', 'KYCController@create_financial');
	Route::post('/financial', 'KYCController@store_financial');
	Route::post('/createwallet/btc/', 'WalletController@create_btcwallet');
	Route::post('/createwallet/ltc/', 'WalletController@create_ltcwallet');
	Route::post('/createwallet/doge/', 'WalletController@create_dogewallet');
	Route::post('/createwallet/eth/', 'WalletController@create_ethwallet');
	Route::post('/createwallet/bch/', 'WalletController@create_bchwallet');
	Route::post('/createwallet/xrp/', 'WalletController@create_xrpwallet');
	Route::get('/getpayaccount/{payid}', 'TradeController@getPayaccount');
	Route::post('/createwallet/qtum/', 'WalletController@create_qtumwallet');

	Route::get('/test', 'FundController@test');


});

// Staff
Route::group(['prefix' => 'staff', 'middleware' => ['auth', 'staff'], 'namespace' => 'Staff'], function () {

	Route::get('/dashboard', 'DashboardController@index');
	Route::get('/ticket', 'TicketsController@index');
	Route::get('/ticket/{id}', 'TicketsController@show');
	Route::post('/ticket/storecomment', 'TicketsController@storecomment');
	Route::get('/ticket/update/{statusid}/{id}', 'TicketsController@update');
	Route::get('/ticket/download/{id}/{ticketid}', 'TicketsController@download');
	Route::get('/changepassword', 'ProfileController@changepassword');
	Route::post('/updatechangepassword', 'ProfileController@update_change_password');
});

Route::get('/admin/logout', 'Auth\LoginController@logout')->name('logout');
Route::post('/admin/logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/users/{id}/impersonate', 'UserController@impersonate');
Route::get('/users/stop', 'UserController@stopImpersonate');

// Pages
Route::get('/about', 'PageController@about');
Route::get('/page/{slug}', 'PageController@show');
Route::get('/faq', 'PageController@faq');
Route::get('/privacy', 'PageController@privacy');
Route::get('/terms', 'PageController@terms');
Route::get('/news', 'PageController@news');
Route::get('/page', 'PageController@page');
Route::get('/news/{id}', 'PageController@newsDetails');
Route::get('/latestnews', 'PageController@Latestnews');

Route::get('/contact', 'ContactController@create');
Route::post('/contact', 'ContactController@store');

Route::get('/emailverification/{token}', 'EmailverificationController@emailverification');

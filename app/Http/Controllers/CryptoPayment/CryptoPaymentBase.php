<?php 
namespace App\Http\Controllers\CryptoPayment;
use App\Http\Controllers\CryptoPayment\CryptoBitcoind;
use App\Http\Controllers\CryptoPayment\CryptoBlockio;
use Config;
use App\Http\Controllers\CryptoPayment\CryptoLitecoind;
use App\Http\Controllers\CryptoPayment\CryptoEth;
use App\Http\Controllers\CryptoPayment\CryptoBch;
use App\Http\Controllers\CryptoPayment\CryptoQtumd;

Class CryptoPaymentBase 
{

	

	public function __construct()
	{
		
	}
	//BTC Start
	public static function getbtcdriver()
	{
		$driver=Config::get('cryptopayment.coin.btc.driver');
		$driverpath='App\Http\Controllers\CryptoPayment'.'\Crypto'.ucfirst($driver);
		return $driverpath;
	}
	
	public static function crypto_getBTCWalletBalance($btc_account)
	{
		$driverpath=CryptoPaymentBase::getbtcdriver();
	

		$balance= $driverpath::crypto_getBTCWalletBalance($btc_account);
		return $balance;
		
	}

	public static function crypto_createBTCAddress($user)
	{
		$driverpath=CryptoPaymentBase::getbtcdriver();
		$response= $driverpath::crypto_createBTCAddress($user);

		return $response;
		
	}

	public static function crypto_sendBTC($array)
	{
		$driverpath=CryptoPaymentBase::getbtcdriver();
		$response= $driverpath::crypto_sendBTC($array);
		
		return $response;
		
	}
	public static function crypto_sendBTCToAdmin($array)
	{
		$driverpath=CryptoPaymentBase::getbtcdriver();
		$response= $driverpath::crypto_sendBTCToAdmin($array);
		
		return $response;
		
	}
	public static function crypto_calculateBTCAdminFee($amount)
	{
		$driverpath=CryptoPaymentBase::getbtcdriver();
		$fee= $driverpath::crypto_calculateBTCAdminFee($amount);
		
		return $fee;
		
	}
	public static function crypto_getBTCWalletAdminBalance()
	{
		$driverpath=CryptoPaymentBase::getbtcdriver();
		$response= $driverpath::crypto_getBTCWalletAdminBalance();
		
		return $response;
		
	}
	public static function crypto_sendBTCToUserFromAdmin($array)
	{
		$driverpath=CryptoPaymentBase::getbtcdriver();
		$response= $driverpath::crypto_sendBTCToUserFromAdmin($array);
		
		return $response;
		
	}
	public static function crypto_calculateBTCFee($amount,$address)
	{
		$driverpath=CryptoPaymentBase::getbtcdriver();
		$fee= $driverpath::crypto_calculateBTCFee($amount,$address);
		
		return $fee;
		
	}
	public static function crypto_getAdminBTCAddress()
	{
		$driverpath=CryptoPaymentBase::getbtcdriver();
		$address= $driverpath::crypto_getAdminBTCAddress();
		
		return $address;
		
	}
	public static function crypto_getBTCWalletBalanceByAccount($account)
	{
		$driverpath=CryptoPaymentBase::getbtcdriver();
		$balance= $driverpath::crypto_getBTCWalletBalanceByAccount($account);
		
		return $balance;
		
	}
	public static function crypto_moveBTC($array)
	{
		$driverpath=CryptoPaymentBase::getbtcdriver();
		$response= $driverpath::crypto_moveBTC($array);
		
		return $response;
		
	}
	public static function crypto_getaccount($address)
	{
		$driverpath=CryptoPaymentBase::getbtcdriver();
		$address= $driverpath::crypto_getaccount($address);
		
		return $address;
		
	}

	//BTC End
	//LTC Start
	public static function getltcdriver()
	{
		$driver=Config::get('cryptopayment.coin.ltc.driver');
		$driverpath='App\Http\Controllers\CryptoPayment'.'\Crypto'.ucfirst($driver);
		return $driverpath;
	}
	public static function crypto_getLTCWalletBalance($ltc_account)
	{
		$driverpath=CryptoPaymentBase::getltcdriver();
		$balance= $driverpath::crypto_getLTCWalletBalance($ltc_account);
		return $balance;
		
	}
	public static function crypto_createLTCAddress($user)
	{
		$driverpath=CryptoPaymentBase::getltcdriver();
		$response= $driverpath::crypto_createLTCAddress($user);

		return $response;
		
	}

	public static function crypto_sendLTC($array)
	{
		$driverpath=CryptoPaymentBase::getltcdriver();
		$response= $driverpath::crypto_sendLTC($array);
		
		return $response;
		
	}
	public static function crypto_sendLTCToAdmin($array)
	{
		$driverpath=CryptoPaymentBase::getltcdriver();
		$response= $driverpath::crypto_sendLTCToAdmin($array);
		
		return $response;
		
	}
	public static function crypto_calculateLTCAdminFee($amount)
	{
		$driverpath=CryptoPaymentBase::getltcdriver();
		$fee= $driverpath::crypto_calculateLTCAdminFee($amount);
		
		return $fee;
		
	}

	public static function crypto_sendLTCToUserFromAdmin($array)
	{
		$driverpath=CryptoPaymentBase::getltcdriver();
		$response= $driverpath::crypto_sendLTCToUserFromAdmin($array);
		
		return $response;
		
	}
	public static function crypto_getLTCWalletAdminBalance()
	{
		$driverpath=CryptoPaymentBase::getltcdriver();
		$response= $driverpath::crypto_getLTCWalletAdminBalance();
		
		return $response;
		
	}
	public static function crypto_calculateLTCFee($amount,$address)
	{
		$driverpath=CryptoPaymentBase::getltcdriver();
		$fee= $driverpath::crypto_calculateLTCFee($amount,$address);
		
		return $fee;
		
	}

	public static function crypto_getAdminLTCAddress()
	{
		$driverpath=CryptoPaymentBase::getltcdriver();
		$address= $driverpath::crypto_getAdminLTCAddress();
		
		return $address;
		
	}

	public static function crypto_getLTCaccount($address)
	{
		$driverpath=CryptoPaymentBase::getltcdriver();
		$address= $driverpath::crypto_getLTCaccount($address);
		
		return $address;
		
	}
	public static function crypto_getLTCWalletBalanceByAccount($account)
	{
		$driverpath=CryptoPaymentBase::getltcdriver();
		$balance= $driverpath::crypto_getLTCWalletBalanceByAccount($account);
		
		return $balance;
		
	}
	public static function crypto_moveLTC($array)
	{
		$driverpath=CryptoPaymentBase::getltcdriver();
		$response= $driverpath::crypto_moveLTC($array);
		
		return $response;
		
	}

	//LTC End
	//ETH Start
	public static function getethdriver()
	{
		$driver=Config::get('cryptopayment.coin.eth.driver');
		$driverpath='App\Http\Controllers\CryptoPayment'.'\Crypto'.ucfirst($driver);
		return $driverpath;
	}

	public static function crypto_createETHAddress($user,$eth_passphrase)
	{
		$driverpath=CryptoPaymentBase::getethdriver();
		$response= $driverpath::crypto_createETHAddress($user,$eth_passphrase);

		return $response;
		
	}
	public static function crypto_getETHWalletBalance($eth_address)
	{
		$driverpath=CryptoPaymentBase::getethdriver();

		$balance= $driverpath::crypto_getETHWalletBalance($eth_address);
		return $balance;
		
	}
	public static function crypto_getETHWalletAdminBalance()
	{
		$driverpath=CryptoPaymentBase::getethdriver();
		$response= $driverpath::crypto_getETHWalletAdminBalance();
		
		return $response;
	}
	public static function crypto_calculateETHFee()
	{
		$driverpath=CryptoPaymentBase::getethdriver();
		$response= $driverpath::crypto_calculateETHFee();
		
		return $response;
	}
	public static function crypto_sendETHToUserFromAdmin($array)
	{
		$driverpath=CryptoPaymentBase::getethdriver();
		$response= $driverpath::crypto_sendETHToUserFromAdmin($array);
		
		return $response;
		
	}
	public static function crypto_sendETH($array)
	{
		$driverpath=CryptoPaymentBase::getethdriver();
		$response= $driverpath::crypto_sendETH($array);
		
		return $response;
		
	}
	public static function crypto_getAdminETHAddress()
	{
		$driverpath=CryptoPaymentBase::getethdriver();
		$address= $driverpath::crypto_getAdminETHAddress();
		
		return $address;
		
	}
	public static function crypto_sendETHToAdmin($array)
	{
		$driverpath=CryptoPaymentBase::getethdriver();
		$response= $driverpath::crypto_sendETHToAdmin($array);
		
		return $response;
		
	}
	//ETH End
	//BCH Start

	public static function getbchdriver()
	{
		$driver=Config::get('cryptopayment.coin.bch.driver');
		$driverpath='App\Http\Controllers\CryptoPayment'.'\Crypto'.ucfirst($driver);
		return $driverpath;
	}

	public static function crypto_getBCHWalletBalance($bch_address)
	{
		$driverpath=CryptoPaymentBase::getbchdriver();

		$balance= $driverpath::crypto_getBCHWalletBalance($bch_address);
		return $balance;
		
	}

	public static function crypto_getBCHWalletAdminBalance()
	{
		$driverpath=CryptoPaymentBase::getbchdriver();
		$response= $driverpath::crypto_getBCHWalletAdminBalance();
		
		return $response;
		
	}

	public static function crypto_createBCHAddress($user)
	{
		$driverpath=CryptoPaymentBase::getbchdriver();
		$response= $driverpath::crypto_createBCHAddress($user);

		return $response;
		
	}


	public static function crypto_sendBCH($array)
	{
		$driverpath=CryptoPaymentBase::getbchdriver();
		$response= $driverpath::crypto_sendBCH($array);
		
		return $response;
		
	}
	public static function crypto_sendBCHToAdmin($array)
	{
		$driverpath=CryptoPaymentBase::getbchdriver();
		$response= $driverpath::crypto_sendBCHToAdmin($array);
		
		return $response;
		
	}
	public static function crypto_calculateBCHAdminFee($amount)
	{
		$driverpath=CryptoPaymentBase::getbchdriver();
		$fee= $driverpath::crypto_calculateBCHAdminFee($amount);
		
		return $fee;
		
	}
		public static function crypto_sendBCHToUserFromAdmin($array)
	{
		$driverpath=CryptoPaymentBase::getbchdriver();
		$response= $driverpath::crypto_sendBCHToUserFromAdmin($array);
		
		return $response;
		
	}
	public static function crypto_calculateBCHFee($amount,$address)
	{
		$driverpath=CryptoPaymentBase::getbchdriver();
		$fee= $driverpath::crypto_calculateBCHFee($amount,$address);
		
		return $fee;
		
	}
	public static function crypto_getAdminBCHAddress()
	{
		$driverpath=CryptoPaymentBase::getbchdriver();
		$address= $driverpath::crypto_getAdminBCHAddress();
		
		return $address;
		
	}
	public static function crypto_getBCHaccount($address)
	{
		$driverpath=CryptoPaymentBase::getbchdriver();
		$address= $driverpath::crypto_getBCHaccount($address);
		
		return $address;
		
	}
	public static function crypto_getBCHWalletBalanceByAccount($account)
	{
		$driverpath=CryptoPaymentBase::getbchdriver();
		$balance= $driverpath::crypto_getBCHWalletBalanceByAccount($account);
		
		return $balance;
		
	}
	public static function crypto_moveBCH($array)
	{
		$driverpath=CryptoPaymentBase::getbchdriver();
		$response= $driverpath::crypto_moveBCH($array);
		
		return $response;
		
	}


	//BCH End


	//QTUm Start
	public static function getqtumdriver()
	{
		$driver=Config::get('cryptopayment.coin.qtum.driver');
		$driverpath='App\Http\Controllers\CryptoPayment'.'\Crypto'.ucfirst($driver);
		return $driverpath;
	}
	
	public static function crypto_getQTUMWalletBalance($qtum_account)
	{
		$driverpath=CryptoPaymentBase::getqtumdriver();
	

		$balance= $driverpath::crypto_getQTUMWalletBalance($qtum_account);
		return $balance;
		
	}

	public static function crypto_createQTUMAddress($user)
	{
		$driverpath=CryptoPaymentBase::getqtumdriver();
		$response= $driverpath::crypto_createQTUMAddress($user);

		return $response;
		
	}

	public static function crypto_sendQTUM($array)
	{
		$driverpath=CryptoPaymentBase::getqtumdriver();
		$response= $driverpath::crypto_sendQTUM($array);
		
		return $response;
		
	}
	public static function crypto_sendQTUMToAdmin($array)
	{
		$driverpath=CryptoPaymentBase::getqtumdriver();
		$response= $driverpath::crypto_sendQTUMToAdmin($array);
		
		return $response;
		
	}
	public static function crypto_calculateQTUMAdminFee($amount)
	{
		$driverpath=CryptoPaymentBase::getqtumdriver();
		$fee= $driverpath::crypto_calculateQTUMAdminFee($amount);
		
		return $fee;
		
	}
	public static function crypto_getQTUMWalletAdminBalance()
	{
		$driverpath=CryptoPaymentBase::getqtumdriver();
		$response= $driverpath::crypto_getQTUMWalletAdminBalance();
		
		return $response;
		
	}
	public static function crypto_sendQTUMToUserFromAdmin($array)
	{
		$driverpath=CryptoPaymentBase::getqtumdriver();
		$response= $driverpath::crypto_sendQTUMToUserFromAdmin($array);
		
		return $response;
		
	}
	public static function crypto_calculateQTUMFee($amount,$address)
	{
		$driverpath=CryptoPaymentBase::getqtumdriver();
		$fee= $driverpath::crypto_calculateQTUMFee($amount,$address);
		
		return $fee;
		
	}
	public static function crypto_getAdminQTUMAddress()
	{
		$driverpath=CryptoPaymentBase::getqtumdriver();
		$address= $driverpath::crypto_getAdminQTUMAddress();
		
		return $address;
		
	}
	public static function crypto_moveQTUM(){
		$driverpath=CryptoPaymentBase::getqtumdriver();
		$response= $driverpath::crypto_moveQTUM($array);
		
		return $response;
	}
	public static function crypto_qtumgetaccount($address)
	{
		$driverpath=CryptoPaymentBase::getqtumdriver();
		$address= $driverpath::crypto_getQTUMaccount($address);
		
		return $address;
		
	}
	public static function crypto_getQTUMWalletBalanceByAccount($account)
	{
		$driverpath=CryptoPaymentBase::getqtumdriver();
		$balance= $driverpath::crypto_getQTUMWalletBalanceByAccount($account);
		
		return $balance;
		
	}
	//QTUM End
}

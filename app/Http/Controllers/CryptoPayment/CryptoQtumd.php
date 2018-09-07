<?php
namespace App\Http\Controllers\CryptoPayment;

use Config;
use Exception;
use Qtumd;

class CryptoQtumd
{
    public static function crypto_getQTUMWalletBalance($qtum_account)
    {

        $available_balance = 0;
        try {

            $blockInfo = Qtumd::getbalance($qtum_account->qtum_label);
            $balance = response()->json($blockInfo->get());
            $available_balance = str_replace('"', '', $balance->getContent());

        } finally {
            return $available_balance;
        }
    }
    public static function crypto_createQTUMAddress($user)
    {
        $response = array();
        try {

            $domain = explode('//', Config::get('app.url'));
            $domain = str_replace('/', '', $domain[1]);
            $account = $domain . "-" . $user->id . "-" . $user->name . "-" . str_random(10) . "-" . date('Y-m-dH-i-s');
            $blockInfo = Qtumd::getaccountaddress($account);
            // return response()->json($blockInfo->get());
            $qtumaddress = response()->json($blockInfo->get());

            $qtum_address = str_replace('"', '', $qtumaddress->getContent());
            $response['address'] = $qtum_address;
            $response['label'] = $account;
            return $response;
        } catch (Exception $e) {
            return $e;

        }

    }

    public static function crypto_sendQTUM($array)
    {
        $response = array();
        try {
            $minconf = (int) Config::get('cryptopayment.coin.qtum.min_confirmation');
            $blockInfo = Qtumd::sendfrom($array['fromaccount'], $array['to_address'], $array['amount'], $minconf, $array['comment'], $array['comment_to']);
            $txn = response()->json($blockInfo->get());
            $txn = str_replace('"', '', $txn->getContent());
            $response = ['txn_id' => $txn, 'driver' => 'Qtumd'];
            return $response;
        } catch (Exception $e) {
            return $response;

        }

    }
    public static function crypto_sendQTUMToAdmin($array)
    {
        $response = array();
        try {
            $minconf = (int) Config::get('cryptopayment.coin.qtum.min_confirmation');
            $address = Config::get('cryptopayment.coin.qtum.address');
            $blockInfo = Qtumd::sendfrom($array['fromaccount'], $address, $array['amount'], $minconf, $array['comment'], $array['comment_to']);
            $txn = response()->json($blockInfo->get());
            $txn = str_replace('"', '', $txn->getContent());
            $response = ['txn_id' => $txn, 'driver' => 'Qtumd'];
            return $response;
        } catch (Exception $e) {
            return $response;

        }

    }
    public static function crypto_calculateQTUMAdminFee($amount)
    {
        $fee = 0;

        try {

            return $fee;
        } catch (Exception $e) {
            return $fee;

        }

    }
    public static function crypto_sendQTUMToUserFromAdmin($array)
    {
        $response = array();
        try {
            $minconf = (int) Config::get('cryptopayment.coin.qtum.min_confirmation');
            $address = Config::get('cryptopayment.coin.qtum.address');
            $blockInfo = Qtumd::getaccount($address);
            $from_account = response()->json($blockInfo->get());
            $from_account = str_replace('"', '', $from_account->getContent());

            $blockInfo = Qtumd::sendfrom($from_account, $array['to_address'], $array['amount'], $minconf, $array['comment'], $array['comment_to']);
            $txn = response()->json($blockInfo->get());
            $txn = str_replace('"', '', $txn->getContent());
            $response = ['txn_id' => $txn, 'driver' => 'Qtumd'];
            return $response;
        } catch (Exception $e) {
            return $response;

        }

    }
    public static function crypto_getQTUMWalletAdminBalance()
    {

        $available_balance = 0;
        try {

            $address = Config::get('cryptopayment.coin.qtum.address');
            $blockInfo = Qtumd::getaccount($address);
            $account = response()->json($blockInfo->get());
            $account = str_replace('"', '', $account->getContent());

            $blockInfo = Qtumd::getbalance($account);
            $balance = response()->json($blockInfo->get());
            $available_balance = str_replace('"', '', $balance->getContent());

        } finally {
            return $available_balance;
        }
    }
    public static function crypto_calculateQTUMFee($amount, $address)
    {
        $fee = 0;

        try {

            return $fee;
        } catch (Exception $e) {
            return $fee;

        }

    }

    public static function crypto_getAdminQTUMAddress()
    {
        $address = '';
        try {

            $address = Config::get('cryptopayment.coin.qtum.address');

            return $address;
        } catch (Exception $e) {
            return $address;

        }

    }
    public static function crypto_moveQTUM($array)
    {
        $response = [];

        try {
            $minconf = (int) Config::get('cryptopayment.coin.qtum.qtumd.min_confirmation');
            $blockInfo = Qtumd::move($array['fromaccount'], $array['toaccount'], $array['amount'], $minconf, $array['comment']);
            $response = response()->json($blockInfo->get());
            return $response;
        } catch (Exception $e) { //dd($e->getMessage());
            return $response;

        }

    }

    public static function crypto_getQTUMaccount($address)
    {
        $response = [];

        try {

            $blockInfo = Qtumd::getaccount($address);
            $response = response()->json($blockInfo->get());
            $response = str_replace('"', '', $response->getContent());
            return $response;
        } catch (Exception $e) {
            // dd($e->getMessage());
            return $response;

        }

	}
	public static function crypto_getQTUMWalletBalanceByAccount($account)
	{
  
			  $available_balance=0;
			  try{
					  $blockInfo = Qtumd::getbalance($account);
					  $balance= response()->json($blockInfo->get());
					  $available_balance=str_replace('"','',$balance->getContent());
  
				}
  
  
			  
			  finally{
				  return $available_balance;
			  }
	}

}

<?php 
namespace App\Http\Controllers\CryptoPayment;
use Config;
use Bitcoind;
use Exception;

Class CryptoBitcoind 
{
	public static function crypto_getBTCWalletBalance($btc_account)
	{

		$available_balance=0;
            try{

            
                    $blockInfo = Bitcoind::getbalance($btc_account->btc_label);
                    $balance= response()->json($blockInfo->get());
                    $available_balance=str_replace('"','',$balance->getContent());

              }


            
            finally{
                return $available_balance;
            }
	}
	public static function crypto_createBTCAddress($user)
	{
			$response=array();
		try{

			$domain=explode('//',Config::get('app.url'));
			$domain=str_replace('/','',$domain[1]);
			$account=$domain."-".$user->id."-".$user->name."-".str_random(10)."-".date('Y-m-dH-i-s');
			$blockInfo = Bitcoind::getaccountaddress($account);
			// return response()->json($blockInfo->get());
			$btcaddress=response()->json($blockInfo->get());

			$btc_address=str_replace('"','',$btcaddress->getContent());
			  $response['address']=$btc_address;
              $response['label']=$account;
			return $response;
      }
      catch(Exception $e)
      {
           return $response;

      }

	}

	public static function crypto_sendBTC($array)
	{
		$response=array();
		try{
			   $minconf=(int)Config::get('cryptopayment.coin.btc.bitcoind.min_confirmation');
			    $blockInfo = Bitcoind::sendfrom($array['fromaccount'],$array['to_address'],$array['amount'],$minconf,$array['comment'],$array['comment_to']);
                   $txn= response()->json($blockInfo->get());
                   $txn=str_replace('"','',$txn->getContent());
                   $response=['txn_id'=>$txn,'driver'=>'bitcoind'];
			return $response;
      }
      catch(Exception $e)
      {
           return $response;

      }

	}
     public static function crypto_sendBTCToAdmin($array)
	{
		$response=array();
		try{
			   $minconf=(int)Config::get('cryptopayment.coin.btc.bitcoind.min_confirmation');
			   $address=Config::get('cryptopayment.coin.btc.bitcoind.address');
			    $blockInfo = Bitcoind::sendfrom($array['fromaccount'],$address,$array['amount'],$minconf,$array['comment'],$array['comment_to']);
                   $txn= response()->json($blockInfo->get());
                   $txn=str_replace('"','',$txn->getContent());
                   $response=['txn_id'=>$txn,'driver'=>'bitcoind'];
			return $response;
      }
      catch(Exception $e)
      {
      	//dd($e->getMessage());
           return $response;

      }

	}
	public static function crypto_calculateBTCAdminFee($amount)
	{
			$fee=0;
			
		try{
			   
			return $fee;
      }
      catch(Exception $e)
      {
           return $fee;

      }

	}
	  public static function crypto_sendBTCToUserFromAdmin($array)
	{
		$response=array();
		try{
			   $minconf=(int)Config::get('cryptopayment.coin.btc.bitcoind.min_confirmation');
			   $address=Config::get('cryptopayment.coin.btc.bitcoind.address');
			    $blockInfo = Bitcoind::getaccount($address);
       			$from_account=response()->json($blockInfo->get());
       		    $from_account=str_replace('"','',$from_account->getContent());

			    $blockInfo = Bitcoind::sendfrom($from_account,$array['to_address'],$array['amount'],$minconf,$array['comment'],$array['comment_to']);
                   $txn= response()->json($blockInfo->get());
                   $txn=str_replace('"','',$txn->getContent());
                   $response=['txn_id'=>$txn,'driver'=>'bitcoind'];
			return $response;
      }
      catch(Exception $e)
      {
           return $response;

      }

	}
	public static function crypto_getBTCWalletAdminBalance()
	{

		$available_balance=0;
            try{

            	$address=Config::get('cryptopayment.coin.btc.bitcoind.address');
			      $blockInfo = Bitcoind::getaccount($address);
       			$account=response()->json($blockInfo->get());
       		    $account=str_replace('"','',$account->getContent());

                    $blockInfo = Bitcoind::getbalance($account);
                    $balance= response()->json($blockInfo->get());
                    $available_balance=str_replace('"','',$balance->getContent());

              }


            
            finally{
                return $available_balance;
            }
	}
	public static function crypto_calculateBTCFee($amount,$address)
	{
			$fee=0;
			
		try{
			   
			return $fee;
      }
      catch(Exception $e)
      {
           return $fee;

      }

	}

	public static function crypto_getAdminBTCAddress()
	{
		$address='';
		try{
			
			   $address=Config::get('cryptopayment.coin.btc.bitcoind.address');
			   
			return $address;
      }
      catch(Exception $e)
      {
           return $address;

      }

	}

	  public static function crypto_getBTCWalletBalanceByAccount($account)
  {

            $available_balance=0;
            try{
                    $blockInfo = Bitcoind::getbalance($account);
                    $balance= response()->json($blockInfo->get());
                    $available_balance=str_replace('"','',$balance->getContent());

              }


            
            finally{
                return $available_balance;
            }
  }
  public static function crypto_moveBTC($array)
  {
      $response=[];
      
      try{
            $minconf=(int)Config::get('cryptopayment.coin.btc.bitcoind.min_confirmation');
            $blockInfo = Bitcoind::move($array['fromaccount'],$array['toaccount'],$array['amount'],$minconf,$array['comment']);
            $response=response()->json($blockInfo->get());
            return $response;
         }
      catch(Exception $e)
      {//dd($e->getMessage());
           return $response;

      }

  }

public static function crypto_getaccount($address)
  {
      $response=[];
      
      try{
            
            $blockInfo = Bitcoind::getaccount($address);
            $response=response()->json($blockInfo->get());
            $response=str_replace('"','',$response->getContent());
            return $response;
         }
      catch(Exception $e)
      {
       // dd($e->getMessage());
           return $response;

      }

  }

}

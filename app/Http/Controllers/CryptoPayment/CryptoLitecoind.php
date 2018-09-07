<?php 
namespace App\Http\Controllers\CryptoPayment;
use Config;
use Litecoind;
use Exception;
Class CryptoLitecoind 
{
	public static function crypto_getLTCWalletBalance($ltc_account)
	{

		$available_balance=0;
            try{

            
                    $blockInfo = Litecoind::getbalance($ltc_account->ltc_label);
                    $balance= response()->json($blockInfo->get());
                    $available_balance=str_replace('"','',$balance->getContent());

              }


            
            finally{
                return $available_balance;
            }
	}
	public static function crypto_createLTCAddress($user)
	{
			$response=array();
		try{

			$domain=explode('//',Config::get('app.url'));
			$domain=str_replace('/','',$domain[1]);
			$account=$domain."-".$user->id."-".$user->name."-".str_random(10)."-".date('Y-m-dH-i-s');
			$blockInfo = Litecoind::getaccountaddress($account);
			
			$ltcaddress=response()->json($blockInfo->get());

			$ltc_address=str_replace('"','',$ltcaddress->getContent());
			  $response['address']=$ltc_address;
              $response['label']=$account;
			return $response;
      }
      catch(Exception $e)
      {
           return $response;

      }

	}

	public static function crypto_sendLTC($array)
	{
  // dd($array);
		$response=array();
		try{
      

			   $minconf=(int)Config::get('cryptopayment.coin.ltc.litecoind.min_confirmation');

			    $blockInfo = Litecoind::sendfrom($array['fromaccount'],$array['to_address'],$array['amount'],$minconf,$array['comment'],$array['comment_to']);

          //dd($blockInfo);
                   $txn= response()->json($blockInfo->get());
                   $txn=str_replace('"','',$txn->getContent());
                   $response=['txn_id'=>$txn,'driver'=>'litecoind'];

			return $response;
      }
      catch(Exception $e)
      {

           return $response;

      }

	}
     public static function crypto_sendLTCToAdmin($array)
	{
		$response=array();
		try{
			   $minconf=(int)Config::get('cryptopayment.coin.ltc.litecoind.min_confirmation');
			   $address=Config::get('cryptopayment.coin.ltc.litecoind.address');
			    $blockInfo = Litecoind::sendfrom($array['fromaccount'],$address,$array['amount'],$minconf,$array['comment'],$array['comment_to']);
                   $txn= response()->json($blockInfo->get());
                   $txn=str_replace('"','',$txn->getContent());
                   $response=['txn_id'=>$txn,'driver'=>'litecoind'];
			return $response;
      }
      catch(Exception $e)
      {
           return $response;

      }

	}
	public static function crypto_calculateLTCAdminFee($amount)
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
	
	 public static function crypto_sendLTCToUserFromAdmin($array)
	{
		$response=array();
		try{
			   $minconf=(int)Config::get('cryptopayment.coin.ltc.litecoind.min_confirmation');
			   $address=Config::get('cryptopayment.coin.ltc.litecoind.address');
			    $blockInfo = Litecoind::getaccount($address);
       			$from_account=response()->json($blockInfo->get());
       		    $from_account=str_replace('"','',$from_account->getContent());

			    $blockInfo = Litecoind::sendfrom($from_account,$array['to_address'],$array['amount'],$minconf,$array['comment'],$array['comment_to']);
                   $txn= response()->json($blockInfo->get());
                   $txn=str_replace('"','',$txn->getContent());
                   $response=['txn_id'=>$txn,'driver'=>'litecoind'];
			return $response;
      }
      catch(Exception $e)
      {
           return $response;

      }

	}
		public static function crypto_getLTCWalletAdminBalance()
	{

		$available_balance=0;
            try{

            	$address=Config::get('cryptopayment.coin.ltc.litecoind.address');
			    $blockInfo = Litecoind::getaccount($address);
       			$account=response()->json($blockInfo->get());
       		    $account=str_replace('"','',$account->getContent());

                    $blockInfo = Litecoind::getbalance($account);
                    $balance= response()->json($blockInfo->get());
                    $available_balance=str_replace('"','',$balance->getContent());

              }


            
            finally{
                return $available_balance;
            }
	}
	public static function crypto_calculateLTCFee($amount,$address)
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
	public static function crypto_getAdminLTCAddress()
	{
			$address='';
    
		
            try{
            		
            	$address=Config::get('cryptopayment.coin.ltc.litecoind.address');
					
                       return $address;
                }
	      catch(Exception $e)
	      {
	      	          return $address;

	      }
            

	}
	public static function crypto_getLTCaccount($address)
  {
      $response=[];
      
      try{
            
            $blockInfo = Litecoind::getaccount($address);
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
  public static function crypto_getLTCWalletBalanceByAccount($account)
  {

            $available_balance=0;
            try{
                    $blockInfo = Litecoind::getbalance($account);
                    $balance= response()->json($blockInfo->get());
                    $available_balance=str_replace('"','',$balance->getContent());

              }


            
            finally{
                return $available_balance;
            }
  }
  public static function crypto_moveLTC($array)
  {
      $response=[];
      
      try{
            $minconf=(int)Config::get('cryptopayment.coin.ltc.litecoind.min_confirmation');
            $blockInfo = Litecoind::move($array['fromaccount'],$array['toaccount'],$array['amount'],$minconf,$array['comment']);
            $response=response()->json($blockInfo->get());
            return $response;
         }
      catch(Exception $e)
      {//dd($e->getMessage());
           return $response;

      }

  }

}

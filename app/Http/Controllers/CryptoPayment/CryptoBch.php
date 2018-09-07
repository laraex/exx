<?php 
namespace App\Http\Controllers\CryptoPayment;
use Config;
use Bitcoincashd;
use Exception;

Class CryptoBch
{
	public static function crypto_getBCHWalletBalance($bch_account)
	{

		$available_balance=0;
            try{

            
                    $blockInfo = Bitcoincashd::getbalance($bch_account->bch_label);
                    $balance= response()->json($blockInfo->get());
                    $available_balance=str_replace('"','',$balance->getContent());

              }


            
            finally{
                return $available_balance;
            }
	}
  public static function crypto_createBCHAddress($user)
	{
			$response=array();
		try{

			$domain=explode('//',Config::get('app.url'));
			$domain=str_replace('/','',$domain[1]);
			$account=$domain."-".$user->id."-".$user->name."-".str_random(10)."-".date('Y-m-dH-i-s');
			$blockInfo = Bitcoincashd::getaccountaddress($account);
				$bchaddress=response()->json($blockInfo->get());

			$bch_address=str_replace('"','',$bchaddress->getContent());
			  $response['address']=$bch_address;
              $response['label']=$account;
			return $response;
      }
      catch(Exception $e)
      {
           return $response;

      }

	}

	 public static function crypto_sendBCH($array)
	{
		$response=array();
		try{
			   $minconf=(int)Config::get('cryptopayment.coin.bch.bitcoincash.min_confirmation');
			    $blockInfo = Bitcoincashd::sendfrom($array['fromaccount'],$array['to_address'],$array['amount'],$minconf,$array['comment'],$array['comment_to']);
                   $txn= response()->json($blockInfo->get());
                   $txn=str_replace('"','',$txn->getContent());
                   $response=['txn_id'=>$txn,'driver'=>'bitcoincashd'];
			return $response;
      }
      catch(Exception $e)
      {
           return $response;

      }

	}
     public static function crypto_sendBCHToAdmin($array)
	{
		$response=array();
		try{
			   $minconf=(int)Config::get('cryptopayment.coin.bch.bitcoincash.min_confirmation');
			   $address=Config::get('cryptopayment.coin.bch.bitcoincash.address');
			    $blockInfo = Bitcoincashd::sendfrom($array['fromaccount'],$address,$array['amount'],$minconf,$array['comment'],$array['comment_to']);
                   $txn= response()->json($blockInfo->get());
                   $txn=str_replace('"','',$txn->getContent());
                   $response=['txn_id'=>$txn,'driver'=>'bitcoincashd'];
			return $response;
      }
      catch(Exception $e)
      {
           return $response;

      }

	}
	public static function crypto_calculateBCHCAdminFee($amount)
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
	  public static function crypto_sendBCHToUserFromAdmin($array)
	{
		$response=array();
		try{
			   $minconf=(int)Config::get('cryptopayment.coin.bch.bitcoincash.min_confirmation');
			   $address=Config::get('cryptopayment.coin.bch.bitcoincash.address');
			    $blockInfo = Bitcoincashd::getaccount($address);
       			$from_account=response()->json($blockInfo->get());
       		    $from_account=str_replace('"','',$from_account->getContent());

			    $blockInfo = Bitcoincashd::sendfrom($from_account,$array['to_address'],$array['amount'],$minconf,$array['comment'],$array['comment_to']);
                   $txn= response()->json($blockInfo->get());
                   $txn=str_replace('"','',$txn->getContent());
                   $response=['txn_id'=>$txn,'driver'=>'bitcoincashd'];
			return $response;
      }
      catch(Exception $e)
      {
           return $response;

      }

	}
	public static function crypto_getBCHWalletAdminBalance()
	{

		$available_balance=0;
            try{

            	$address=Config::get('cryptopayment.coin.bch.bitcoincash.address');
			        $blockInfo = Bitcoincashd::getaccount($address);
       		  	$account=response()->json($blockInfo->get());
       		    $account=str_replace('"','',$account->getContent());

                    $blockInfo = Bitcoincashd::getbalance($account);
                    $balance= response()->json($blockInfo->get());
                    $available_balance=str_replace('"','',$balance->getContent());

              }


            
            finally{
                return $available_balance;
            }
	}
	public static function crypto_calculateBCHFee($amount,$address)
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
  public static function crypto_calculateBCHAdminFee($amount)
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

  public static function crypto_getAdminBCHAddress()
  {
      $address='';
    
    
            try{
                
                       $address=Config::get('cryptopayment.coin.bch.bitcoincash.address');
          
                       return $address;
                }
        catch(Exception $e)
        {
                    return $address;

        }
            

  }
 public static function crypto_getBCHaccount($address)
  {
      $response=[];
      
      try{
            
            $blockInfo = Bitcoincashd::getaccount($address);
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
public static function crypto_getBCHWalletBalanceByAccount($account)
  {

            $available_balance=0;
            try{
                    $blockInfo = Bitcoincashd::getbalance($account);
                    $balance= response()->json($blockInfo->get());
                    $available_balance=str_replace('"','',$balance->getContent());

              }


            
            finally{
                return $available_balance;
            }
  }
  public static function crypto_moveBCH($array)
  {
      $response=[];
      
      try{
            $minconf=(int)Config::get('cryptopayment.coin.bch.bitcoincash.min_confirmation');
            $blockInfo = Bitcoincashd::move($array['fromaccount'],$array['toaccount'],$array['amount'],$minconf,$array['comment']);
            $response=response()->json($blockInfo->get());
            return $response;
         }
      catch(Exception $e)
      {//dd($e->getMessage());
           return $response;

      }

  }


}

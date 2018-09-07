<?php 
namespace App\Http\Controllers\CryptoPayment;
use Config;
use Exception;

Class CryptoEth
{
   public static function crypto_createETHAddress($user,$eth_passphrase)
	{
		$response=array();
		try{
	
 			  $eth_address = \Jcsofts\LaravelEthereum\Facade\Ethereum::personal_newAccount($eth_passphrase);
			  $response['address']=$eth_address;
              $response['eth_passphrase']=$eth_passphrase;
			return $response;
      }
      catch(Exception $e)
      {
           return $response;

      }

	}
   public static function crypto_getETHWalletBalance($address)
   {

   			$available_balance=0;
            try{
                           
				$available_balance = \Jcsofts\LaravelEthereum\Facade\Ethereum::eth_getBalance($address,'latest','true');
        $available_balance=($available_balance/(pow(10,18)));  
            }
		     catch(Exception $e)
		      {
		          return $available_balance;

		      }
            finally{
                return $available_balance;
            }
       
   }

	
    public static function crypto_getETHWalletAdminBalance()
   {

        $available_balance=0;
            try{
               $address=Config::get('cryptopayment.coin.eth.ethereum.address');                 
        $available_balance = \Jcsofts\LaravelEthereum\Facade\Ethereum::eth_getBalance($address,'latest','true');
        $available_balance=($available_balance/(pow(10,18)));  
            }
         catch(Exception $e)
          {
              return $available_balance;

          }
            finally{
                return $available_balance;
            }
       
   }



  public static function crypto_calculateETHFee()
  {
      $fee=0.01;
      
    try{
         
      return $fee;
      }
      catch(Exception $e)
      {
           return $fee;

      }

  }

  public static function crypto_sendETHToUserFromAdmin($array)
  {
    $response=array();
    
    
            try{
                
                    $amount=$array['amount'];
                    $value=$amount*(pow(10,18));
                    $value = '0x'.dechex($value);
                    $address=Config::get('cryptopayment.coin.eth.ethereum.address');
                    $pass_phrase=Config::get('cryptopayment.coin.eth.ethereum.passphrase');
                    $params= new \Jcsofts\LaravelEthereum\Lib\EthereumTransaction(
                          $address,
                          $array['to'],
                          $value,
                          '',
                          '',
                          '',
                          ''

                    );
                    $txn= \Jcsofts\LaravelEthereum\Facade\Ethereum::personal_sendTransaction($params,$pass_phrase);

                    $response=['txn_id'=>$txn,'driver'=>'ethereum'];
                       return $response;
                }
        catch(Exception $e)
        {
        //echo $e->getMessage();exit;
                return $response;

        }
            

  }
   
  public static function crypto_sendETH($array)
  {
    $response=array();
    
    
            try{
                
                    $amount=$array['amount'];
                    $value=$amount*(pow(10,18));
                    $value = '0x'.dechex($value);
                    
                    $pass_phrase=$array['passphrase'];
                    $params= new \Jcsofts\LaravelEthereum\Lib\EthereumTransaction(
                          $array['from_address'],
                          $array['to_address'],
                          $value,
                          '',
                          '',
                          '',
                          ''
                    );
                    $txn= \Jcsofts\LaravelEthereum\Facade\Ethereum::personal_sendTransaction($params,$pass_phrase);

                    $response=['txn_id'=>$txn,'driver'=>'ethereum'];
                       return $response;
                }
        catch(Exception $e)
        {
<<<<<<< HEAD
=======
         //echo $e->getMessage();exit;
>>>>>>> d61d8871a3cad8f905d3a06379dda62744837c04
                return $response;

        }
            

  }
  public static function crypto_getAdminETHAddress()
  {
      $address='';
    
    
            try{
                
               $address=Config::get('cryptopayment.coin.eth.ethereum.address');
          
                       return $address;
                }
        catch(Exception $e)
        {
                    return $address;

        }
            

  }
   public static function crypto_sendETHToAdmin($array)
  {
    $response=array();
    
    
            try{
                
                    $amount=$array['amount'];
                    $value=$amount*(pow(10,18));
                    $value = '0x'.dechex($value);
                    $address=Config::get('cryptopayment.coin.eth.ethereum.address');
               
                    $params= new \Jcsofts\LaravelEthereum\Lib\EthereumTransaction(
                          $array['from_address'],
                          $address,
                          $value,
                          '',
                          '',
                          '',
                          ''

                    );
                    $txn= \Jcsofts\LaravelEthereum\Facade\Ethereum::personal_sendTransaction($params,$array['pass_phrase']);
                    $lockaccount=\Jcsofts\LaravelEthereum\Facade\Ethereum::personal_lockAccount($array['from_address']);
                    $response=['txn_id'=>$txn,'driver'=>'ethereum'];

                   
                       return $response;
                }
        catch(Exception $e)
        {
        //echo $e->getMessage();exit;
                return $response;

        }
            

  }

}

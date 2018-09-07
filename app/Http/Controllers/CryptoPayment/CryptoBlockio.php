<?php 
namespace App\Http\Controllers\CryptoPayment;
use Config;
use App\Classes\block_io\BlockIo;
use Exception;
Class CryptoBlockio 
{
	//BTC Start
	public static function crypto_getBTCWalletBalance($btc_account)
	{

		$available_balance=0;
            try{
                           

					$api_key=Config::get('cryptopayment.coin.btc.blockio.apikey');
					$pin=Config::get('cryptopayment.coin.btc.blockio.pin');
					$version=Config::get('cryptopayment.coin.btc.blockio.version');
					$block_io = new BlockIo( $api_key, $pin, $version);

					$balance = $block_io->get_address_balance(array('addresses' => $btc_account->btc_address));
					$available_balance = $balance->data->available_balance;
           
            }
		     catch(Exception $e)
		      {
		          return $available_balance;

		      }
            finally{
                return $available_balance;
            }
	}
	public static function crypto_createBTCAddress($user)
	{
		$response=array();
    
		 $address='';
            try{
            		$label=$user->name."-".date('Y-m-dH-i-s');
            	    $api_key=Config::get('cryptopayment.coin.btc.blockio.apikey');
					$pin=Config::get('cryptopayment.coin.btc.blockio.pin');
					$version=Config::get('cryptopayment.coin.btc.blockio.version');
					$block_io = new BlockIo($api_key,$pin,$version);
                    $walletaddress = $block_io->get_new_address(array('label' => $label));
                    $address = $walletaddress->data->address;
                    $response['address']=$address;
                	$response['label']=$label;
                }
	      catch(Exception $e)
	      {
	      	//echo $e->getMessage();exit;
	              return $response;

	      }
            finally
                {
                	
          
                     return $response;
                }

	}
	public static function crypto_sendBTC($array)
	{
		$response=array();
    
		
            try{
            		
            	    $api_key=Config::get('cryptopayment.coin.btc.blockio.apikey');
					$pin=Config::get('cryptopayment.coin.btc.blockio.pin');
					$version=Config::get('cryptopayment.coin.btc.blockio.version');
					$block_io = new BlockIo($api_key,$pin,$version);
                    $response=$block_io->withdraw_from_addresses(array('amounts' => $array['amount'], 'from_addresses' =>$array['from_address'],'to_addresses' =>$array['to_address']));
                       return $response;
                }
	      catch(Exception $e)
	      {
	      //	echo $e->getMessage();exit;
	              return $response;

	      }
            

	}
	public static function crypto_sendBTCToAdmin($array)
	{
		$response=array();
    
		
            try{
            		
            	    $api_key=Config::get('cryptopayment.coin.btc.blockio.apikey');
					$pin=Config::get('cryptopayment.coin.btc.blockio.pin');
					$version=Config::get('cryptopayment.coin.btc.blockio.version');
					$address=Config::get('cryptopayment.coin.btc.blockio.address');
					$block_io = new BlockIo($api_key,$pin,$version);
                    $response=$block_io->withdraw_from_addresses(array('amounts' => $array['amount'], 'from_addresses' =>$array['from_address'],'to_addresses' =>$address));
                       return $response;
                }
	      catch(Exception $e)
	      {
	      //echo $e->getMessage();exit;
	              return $response;

	      }
            

	}

	public static function crypto_calculateBTCAdminFee($amount)
	{
		$total=0;
    
		
            try{
            		
            	    $api_key=Config::get('cryptopayment.coin.btc.blockio.apikey');
					$pin=Config::get('cryptopayment.coin.btc.blockio.pin');
					$version=Config::get('cryptopayment.coin.btc.blockio.version');
					$address=Config::get('cryptopayment.coin.btc.blockio.address');
					$block_io = new BlockIo($api_key,$pin,$version);
                   $network_fee=$block_io->get_network_fee_estimate(array('amounts' => $amount, 'to_addresses' => $address));
            
                    $total=$network_fee->data->estimated_network_fee;
                       return $total;
                }
	      catch(Exception $e)
	      {
	      //echo $e->getMessage();exit;
	              return $total;

	      }
            

	}
	public static function crypto_sendBTCToUserFromAdmin($array)
	{
		$response=array();

		//dd($array);
    
	
            try{
            		
            	    $api_key=Config::get('cryptopayment.coin.btc.blockio.apikey');
					$pin=Config::get('cryptopayment.coin.btc.blockio.pin');
					$version=Config::get('cryptopayment.coin.btc.blockio.version');
					$address=Config::get('cryptopayment.coin.btc.blockio.address');
					$block_io = new BlockIo($api_key,$pin,$version);
                    $response=$block_io->withdraw_from_addresses(array('amounts' => $array['amount'], 'from_addresses' =>$address,'to_addresses' =>$array['to_address']));
                    //dd($response);
                       return $response;
                }
	      catch(Exception $e)
	      {
	      //echo $e->getMessage();exit;
	              return $response;

	      }
            

	}
	public static function crypto_getBTCWalletAdminBalance()
	{

		$available_balance=0;
            try{
                           

					$api_key=Config::get('cryptopayment.coin.btc.blockio.apikey');
					$pin=Config::get('cryptopayment.coin.btc.blockio.pin');
					$version=Config::get('cryptopayment.coin.btc.blockio.version');
					$block_io = new BlockIo( $api_key, $pin, $version);
					$address=Config::get('cryptopayment.coin.btc.blockio.address');
					$balance = $block_io->get_address_balance(array('addresses' => $address));
					$available_balance = $balance->data->available_balance;
           
            }
		     catch(Exception $e)
		      {
		          return $available_balance;

		      }
            finally{
                return $available_balance;
            }
	}
	public static function crypto_calculateBTCFee($amount,$address)
	{
		$total=0;
    
		
            try{
            		
            	    $api_key=Config::get('cryptopayment.coin.btc.blockio.apikey');
					$pin=Config::get('cryptopayment.coin.btc.blockio.pin');
					$version=Config::get('cryptopayment.coin.btc.blockio.version');
					
					$block_io = new BlockIo($api_key,$pin,$version);
                   $network_fee=$block_io->get_network_fee_estimate(array('amounts' => $amount, 'to_addresses' => $address));
            
                    $total=$network_fee->data->estimated_network_fee;
                       return $total;
                }
	      catch(Exception $e)
	      {
	      //echo $e->getMessage();exit;
	              return $total;

	      }
            

	}

	public static function crypto_getAdminBTCAddress()
	{
			$address='';
    
		
            try{
            		
            	      $address=Config::get('cryptopayment.coin.btc.blockio.address');
					
                       return $address;
                }
	      catch(Exception $e)
	      {
	      	          return $address;

	      }
            

	}
	//BTC End
	//LTC Start
		public static function crypto_getLTCWalletBalance($ltc_account)
	{

		$available_balance=0;
            try{
                           

					$api_key=Config::get('cryptopayment.coin.ltc.blockio.apikey');
					$pin=Config::get('cryptopayment.coin.ltc.blockio.pin');
					$version=Config::get('cryptopayment.coin.ltc.blockio.version');
					$block_io = new BlockIo( $api_key, $pin, $version);

					$balance = $block_io->get_address_balance(array('addresses' => $ltc_account->ltc_address));
					$available_balance = $balance->data->available_balance;
           
            }
		     catch(Exception $e)
		      {
		          return $available_balance;

		      }
            finally{
                return $available_balance;
            }
	}
	public static function crypto_createLTCAddress($user)
	{
		$response=array();
    
		 $address='';
            try{
            		$label=$user->name."-".date('Y-m-dH-i-s');
            	    $api_key=Config::get('cryptopayment.coin.ltc.blockio.apikey');
					$pin=Config::get('cryptopayment.coin.ltc.blockio.pin');
					$version=Config::get('cryptopayment.coin.ltc.blockio.version');
					$block_io = new BlockIo($api_key,$pin,$version);
                    $walletaddress = $block_io->get_new_address(array('label' => $label));
                    $address = $walletaddress->data->address;
                    $response['address']=$address;
                	$response['label']=$label;
                }
	      catch(Exception $e)
	      {
	      	//echo $e->getMessage();exit;
	              return $response;

	      }
            finally
                {
                	
          
                     return $response;
                }

	}
	public static function crypto_sendLTC($array)
	{
		$response=array();
    
		
            try{
            		
            	    $api_key=Config::get('cryptopayment.coin.ltc.blockio.apikey');
					$pin=Config::get('cryptopayment.coin.ltc.blockio.pin');
					$version=Config::get('cryptopayment.coin.ltc.blockio.version');
					$block_io = new BlockIo($api_key,$pin,$version);
                    $response=$block_io->withdraw_from_addresses(array('amounts' => $array['amount'], 'from_addresses' =>$array['from_address'],'to_addresses' =>$array['to_address']));
                       return $response;
                }
	      catch(Exception $e)
	      {
	      //	echo $e->getMessage();exit;
	              return $response;

	      }
            

	}
	public static function crypto_sendLTCToAdmin($array)
	{
		$response=array();
    
		
            try{
            		
            	    $api_key=Config::get('cryptopayment.coin.ltc.blockio.apikey');
					$pin=Config::get('cryptopayment.coin.ltc.blockio.pin');
					$version=Config::get('cryptopayment.coin.ltc.blockio.version');
					$address=Config::get('cryptopayment.coin.ltc.blockio.address');
					$block_io = new BlockIo($api_key,$pin,$version);
                    $response=$block_io->withdraw_from_addresses(array('amounts' => $array['amount'], 'from_addresses' =>$array['from_address'],'to_addresses' =>$address));
                       return $response;
                }
	      catch(Exception $e)
	      {
	      echo $e->getMessage();exit;
	      
	              return $response;

	      }
            

	}

	public static function crypto_calculateLTCAdminFee($amount)
	{
		$total=0;
    
		
            try{
            		
            	    $api_key=Config::get('cryptopayment.coin.ltc.blockio.apikey');
					$pin=Config::get('cryptopayment.coin.ltc.blockio.pin');
					$version=Config::get('cryptopayment.coin.ltc.blockio.version');
					$address=Config::get('cryptopayment.coin.ltc.blockio.address');
					$block_io = new BlockIo($api_key,$pin,$version);
                   $network_fee=$block_io->get_network_fee_estimate(array('amounts' => $amount, 'to_addresses' => $address));
            
                    $total=$network_fee->data->estimated_network_fee;
                       return $total;
                }
	      catch(Exception $e)
	      {
	      //echo $e->getMessage();exit;
	              return $total;

	      }
	}

	public static function crypto_sendLTCToUserFromAdmin($array)
	{
		$response=array();
    
		
            try{
            		
            	    $api_key=Config::get('cryptopayment.coin.ltc.blockio.apikey');
					$pin=Config::get('cryptopayment.coin.ltc.blockio.pin');
					$version=Config::get('cryptopayment.coin.ltc.blockio.version');
					$address=Config::get('cryptopayment.coin.ltc.blockio.address');
					$block_io = new BlockIo($api_key,$pin,$version);
                    $response=$block_io->withdraw_from_addresses(array('amounts' => $array['amount'], 'from_addresses' =>$address,'to_addresses' =>$array['to_address']));
                       return $response;
                }
	      catch(Exception $e)
	      {
	      //echo $e->getMessage();exit;
	              return $response;

	      }
            

	}
		public static function crypto_getLTCWalletAdminBalance()
	{

		$available_balance=0;
            try{
                           

					$api_key=Config::get('cryptopayment.coin.ltc.blockio.apikey');
					$pin=Config::get('cryptopayment.coin.ltc.blockio.pin');
					$version=Config::get('cryptopayment.coin.ltc.blockio.version');
					$block_io = new BlockIo( $api_key, $pin, $version);
					$address=Config::get('cryptopayment.coin.ltc.blockio.address');
					$balance = $block_io->get_address_balance(array('addresses' => $address));
					$available_balance = $balance->data->available_balance;
           
            }
		     catch(Exception $e)
		      {
		          return $available_balance;

		      }
            finally{
                return $available_balance;
            }
	}
		public static function crypto_calculateLTCFee($amount,$address)
	{
		$total=0;
    
		
            try{
            		
            	    $api_key=Config::get('cryptopayment.coin.ltc.blockio.apikey');
					$pin=Config::get('cryptopayment.coin.ltc.blockio.pin');
					$version=Config::get('cryptopayment.coin.ltc.blockio.version');
					
					$block_io = new BlockIo($api_key,$pin,$version);
                   $network_fee=$block_io->get_network_fee_estimate(array('amounts' => $amount, 'to_addresses' => $address));
            
                    $total=$network_fee->data->estimated_network_fee;
                       return $total;
                }
	      catch(Exception $e)
	      {
	      //echo $e->getMessage();exit;
	              return $total;

	      }
            

	}
	public static function crypto_getAdminLTCAddress()
	{
			$address='';
    
		
            try{
            		
            	      $address=Config::get('cryptopayment.coin.ltc.blockio.address');
					
                       return $address;
                }
	      catch(Exception $e)
	      {
	      	          return $address;

	      }
            

	}
            
	//LTC End
	

}

<?php

namespace App\Http\Controllers;
use App\Traits\RegistersNewUser;
use App\Traits\Common;
use Exception;

class ETHController extends Controller
{
    use RegistersNewUser,Common;
   public function createAddress($eth_passphrase)
   {//0x1e239f6e3add0b18ce36ba919ac54ec5dc407e3e
       //$address=$this->createETHWallet();
      // return $address;
    
    $response=array();
    try{
  
        $eth_address = \Jcsofts\LaravelEthereum\Facade\Ethereum::personal_newAccount($eth_passphrase);
        $response['address']=$eth_address;
              $response['eth_passphrase']=$eth_passphrase;
      return $response;
      }
      catch(Exception $e)
      {
       // dd($e->getMessage());
           return $response;

      }

    
       return $response;
   }

   
    public function protocolVersion()
   {
        $address='';
           try{
                $ret = \Jcsofts\LaravelEthereum\Facade\Ethereum::eth_protocolVersion();
              
                return $ret;
         
           }

          catch (Exception $e){
              
             return  $e->getMessage();

            }
   }
  public function accounts()
   {
     
           try{
                $ret = \Jcsofts\LaravelEthereum\Facade\Ethereum::eth_accounts();
              
                return $ret;
         
           }

          catch (Exception $e){
              
             return  $e->getMessage();

            }
   }

   public function getBalance($address)
   {
    
           try{
                $ret = \Jcsofts\LaravelEthereum\Facade\Ethereum::eth_getBalance($address,'latest','true');
                $ret=($ret/(pow(10,18)));  
                return $ret;
         
           }

          catch (Exception $e){
              
             return  $e->getMessage();

            }
   }

  public function getTransactionByHash($hash)
   {
    //0xa79376ccfd4b45d3424707e751050f87c743f07d5cd2adc051bbf0228f360a82 0xa7937
           try{
                $ret = \Jcsofts\LaravelEthereum\Facade\Ethereum::eth_getTransactionByHash($hash);
              
                return $ret;
         
           }

          catch (Exception $e){
              
             return  $e->getMessage();

            }
   }

   public function getTransactionReceipt($hash)
   {
    //0xa79376ccfd4b45d3424707e751050f87c743f07d5cd2adc051bbf0228f360a82 0xa7937
           try{
                $ret = \Jcsofts\LaravelEthereum\Facade\Ethereum::eth_getTransactionReceipt($hash);
              
                return $ret;
         
           }

          catch (Exception $e){
              
             return  $e->getMessage();

            }
   }



  public function sendTransaction($from,$to,$amount)
   {
      $from='0x5b28dea2130d161b2550d72ea9cc45c8978dfce2';
      $to='0x2b6a378b7998cde5e9f26da266bbd80a11879a87';
    //  $to='0xd094d59d526a246b051317363c37c869dd88efaa';
      $pass_phrase='bfwv6JWuqr';
      $amount=0.001;
    //  $value=dechex(0.001);
      /*$params['from']=$from;
      $params['to']=$to;
      $params['value']=$amount;
      $params['gas']='';
      $params['gasPrice']='';
      $params['data']='';
      $params['nonce']='';*/
      
    //  $value = dechex($amount);
 $value=$amount*(pow(10,18));
 $value = '0x'.dechex($value);
         
     
         $params= new \Jcsofts\LaravelEthereum\Lib\EthereumTransaction(
              $from,
              $to,
              $value,
              '',
              '',
              '',
              ''

        );
//0x1bf68f558817ba2fc9cf9eb166694116b2b0a43d5b54aabf824a72329a3fb8ad
         //0xbc8c763a43a6bed3497080a64d2682f23a09bc908c0f716955d7610d4a2d699b
           try{
                $ret = \Jcsofts\LaravelEthereum\Facade\Ethereum::personal_sendTransaction($params,$pass_phrase);
              
                return $ret;
         
           }

          catch (Exception $e){
              
             return  $e->getMessage();

            }
   }

/*

  public function gasPrice()
   {
            try{
                $ret = \Jcsofts\LaravelEthereum\Facade\Ethereum::eth_gasPrice();
                $ret=hexdec($ret);
                 $ret=($ret/(pow(10,18))); 
                return $ret;
         
           }

          catch (Exception $e){
              
             return  $e->getMessage();

            }
   }*/

     


}
<?php

namespace App\Http\Controllers;

use Bitcoincashd;
use Gegosoft\Bitcoincash\Client as BitcoincashClient;
class BitcoincashController extends Controller
{
  /**
   * Get block info.
   *
   * @return object
   */
   public function blockInfo()
   {
      $blockHash = '000000000019d6689c085ae165831e934ff763ae46a2a6c172b3f1b60a8ce26f';
      $blockInfo = Bitcoincashd::getBlock($blockHash);
      return response()->json($blockInfo->get());
   }

   public function balance(BitcoincashClient $bitcoincashd,$account)
   {
   
      //$blockInfo = Bitcoincashd::getbalance($account);
      $blockInfo = $bitcoincashd->getbalance($account);
      return response()->json($blockInfo->get());
   }

    public function accountaddress(BitcoincashClient $bitcoincashd)
   {
      $userid=1;
      $username='test';
      $domain=explode('//',getenv('APP_URL'));
      $domain=str_replace('/','',$domain[1]);
      $account=$domain."-".$userid."-".$username."-".str_random(10)."-".date('Y-m-dH-i-s');
     // $blockInfo = Bitcoincashd::getaccountaddress($account);
      $blockInfo = $bitcoincashd->getaccountaddress($account);
      return response()->json($blockInfo->get());
   }
   /*public function getlistaccounts(BitcoincashClient $bitcoincashd)
   {
     //$blockInfo = Bitcoincashd::listaccounts();
      $blockInfo = $bitcoincashd->listaccounts();
      return response()->json($blockInfo->get());
   }*/
   public function getlistaccounts()
   {
      $blockInfo = Bitcoincashd::listaccounts();
    
      return response()->json($blockInfo->get());
   }


   public function send()
   {
      //$fromaccount='--params=[karthick]';
      //$tobitcoinaddress='2N7UNFkEPRe1kjnXHLUwaaFwBry3uqYKT2A';
     // $tobitcoinaddress='2MtGHW5bRSCk1w9NKCQsyA1SdMk7F2RCLAn';
    $fromaccount='';
    $tobitcoinaddress='qqeccld3prcczzss8ck7m75h66pp2cx30clj6kmsuq';

      $amount=1;
      $minconf=0;
      $comment='test';
      $comment_to='test';
      $blockInfo = Bitcoincashd::sendfrom($fromaccount,$tobitcoinaddress,$amount,$minconf,$comment,$comment_to);
      return response()->json($blockInfo->get());
   }

   public function transaction($txn_hash)
   {
      $blockInfo = Bitcoincashd::gettransaction($txn_hash);
      return response()->json($blockInfo->get());
   }

   public function addressesbyaccount(BitcoincashClient $bitcoincashd,$account)
   {
      // $blockInfo = Bitcoincashd::getaddressesbyaccount($account);
        $blockInfo = $bitcoincashd->getaddressesbyaccount($account);
        return response()->json($blockInfo->get());

   }
   public function getlisttransactions($account)
   {

        $blockInfo = Bitcoincashd::listtransactions($account);
        return response()->json($blockInfo->get());
   }
     public function getaccountbyaddress(BitcoincashClient $bitcoincashd,$address)
   {

       // $blockInfo = Bitcoincashd::getaccount($address);
        $blockInfo = $bitcoincashd->getaccount($address);
        return response()->json($blockInfo->get());
   }




}
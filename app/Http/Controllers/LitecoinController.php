<?php

namespace App\Http\Controllers;

use Litecoind;

class LitecoinController extends Controller
{
  /**
   * Get block info.
   *
   * @return object
   */
   public function blockInfo()
   {
      $blockHash = '000000000019d6689c085ae165831e934ff763ae46a2a6c172b3f1b60a8ce26f';
      $blockInfo = Litecoind::getBlock($blockHash);
      return response()->json($blockInfo->get());
   }

   public function balance($account)
   {

      $blockInfo = Litecoind::getbalance($account);
      return response()->json($blockInfo->get());
   }

    public function accountaddress($account)
   {
      $userid=1;
     // $domain="localhost";
      $username='test';
      $domain=explode('//',getenv('APP_URL'));
      $domain=str_replace('/','',$domain[1]);
      $account=$domain."-".$userid."-".$username."-".str_random(10)."-".date('Y-m-dH-i-s');
      $blockInfo = Litecoind::getaccountaddress($account);
      return response()->json($blockInfo->get());
   }
   public function getlistaccounts()
   {
      $blockInfo = Litecoind::listaccounts();
      return response()->json($blockInfo->get());
   }

   public function send()
   {
     // $fromaccount='cointruth.test-1-test-yvB6nVOlez-2018-05-0102-17-40';
      $fromaccount='cointruth.test-1-test-yvB6nVOlez-2018-05-0102-17-40';
     // $tolitecoinaddress='mmFewo38YQoevLBAeg1Y9BHGJ6jAuaZLVp';     
    //  $tolitecoinaddress='mi6Dxg9Ryd9tBSbsMVsCj61vvsUnxmmUiD';     
      $tolitecoinaddress='mvoHLHr3VKszueDfPeKHL2ZJ3aRLrHReQW';     
      $amount=8;
      $minconf=0;
      $comment='test';
      $comment_to='test';

      $blockInfo = Litecoind::sendfrom($fromaccount,$tolitecoinaddress,$amount,$minconf,$comment,$comment_to);
      return response()->json($blockInfo->get());
   }

   public function transaction($txn_hash)
   {
    //6789bd4ba76f678326d35aef022672badaefc54c1858a9554d6644ec573a4112
     //98b2433c6179e39dd99974d75a699b4a644d95832f826585f1283510bab15f56
      $blockInfo = Litecoind::gettransaction($txn_hash);
      return response()->json($blockInfo->get());
   }

   public function addressesbyaccount($account)
   {
       $blockInfo = Litecoind::getaddressesbyaccount($account);
        return response()->json($blockInfo->get());

   }
   public function getlisttransactions($account)
   {

        $blockInfo = Litecoind::listtransactions($account);
        return response()->json($blockInfo->get());
   }
   public function getaccountbyaddress($address)
   {

        $blockInfo = Litecoind::getaccount($address);
        return response()->json($blockInfo->get());
   }




}
<?php

namespace App\Http\Controllers;

use Bitcoind;

class BitcoinController extends Controller
{
  /**
   * Get block info.
   *
   * @return object
   */
   public function blockInfo()
   {
      $blockHash = '000000000019d6689c085ae165831e934ff763ae46a2a6c172b3f1b60a8ce26f';
      $blockInfo = Bitcoind::getBlock($blockHash);
      return response()->json($blockInfo->get());
   }

   public function balance($account)
   {

    //  $account = '--params=[karthick]';
      $blockInfo = Bitcoind::getbalance($account);
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
      $blockInfo = Bitcoind::getaccountaddress($account);
      return response()->json($blockInfo->get());
   }
   public function getlistaccounts()
   {
      $blockInfo = Bitcoind::listaccounts();
      return response()->json($blockInfo->get());
   }

   public function send()
   {
     /* $fromaccount='--params=[karthick]';
      $tobitcoinaddress='2N7UNFkEPRe1kjnXHLUwaaFwBry3uqYKT2A';
      $tobitcoinaddress='2MtGHW5bRSCk1w9NKCQsyA1SdMk7F2RCLAn';*/
     // $fromaccount='dev.bcx.ba-7-testuser1-UeX68mNDS6-2018-05-0314-00-31';
      $fromaccount='bitground.test-8-root-U9gGQPXPfl-2018-07-2509-46-55';
    //  $tobitcoinaddress='2NDkqgK4WCoTp6S3uqYuqQFyShDHYznGoy2';
      $tobitcoinaddress='2MzWxHoiUCKjPoFX3uJEoZomRPkrQiZTm8r';
      $amount=0.00010000;
      $minconf=0;
      $comment='test';
      $comment_to='test';
//a63b9d4442093bd838eb10d635030171fe9ea78f74231a6e9377e703a02a2b74
      $blockInfo = Bitcoind::sendfrom($fromaccount,$tobitcoinaddress,$amount,$minconf,$comment,$comment_to);
      return response()->json($blockInfo->get());
   }

   public function transaction($txn_hash)
   {
     // $txn_hash='a63b9d4442093bd838eb10d635030171fe9ea78f74231a6e9377e703a02a2b74';
      //9d9ced1f3869673fdb83da48331bcc117010620270df0cc4aa1d1b1aad563b63
      //32fa24e395ef71ecd79c8e9c9244c587e1e380f967af8078bb9c4010861c0355
      //35cdfea1f329d0b6bd7a226fb69135636d43d5dca5fda91e13f49fe0ce6a8180
      //1c02c707ea38d1689e18a7f5f550c5711ad4e1250abc82e50c92d39222bfe14e
      //42c685d497f301f16046d3801006f2b1820f2e7978362e1c8d9c7e3db040be2b
      //315c46f406eb5572dbeafcc1008198eff21caaee85a4f4f5c0a49c0e7a9268e0
      $blockInfo = Bitcoind::gettransaction($txn_hash);
      return response()->json($blockInfo->get());
   }

   public function addressesbyaccount($account)
   {
       $blockInfo = Bitcoind::getaddressesbyaccount($account);
        return response()->json($blockInfo->get());

   }
   //for move also
   public function getlisttransactions($account)
   {

        $blockInfo = Bitcoind::listtransactions($account);
        return response()->json($blockInfo->get());
   }
     public function getaccountbyaddress($address)
   {

        $blockInfo = Bitcoind::getaccount($address);
        return response()->json($blockInfo->get());
   }
  public function receivedbyaccount($account)
   {

        $blockInfo = Bitcoind::getreceivedbyaccount($account);
        return response()->json($blockInfo->get());
   }

   public function getlistreceivedbyaccount($account)
   {

        $blockInfo = Bitcoind::listreceivedbyaccount($account);
        return response()->json($blockInfo->get());
   }






}
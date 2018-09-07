<?php

use Illuminate\Database\Seeder;

class CurrenciesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('currencies')->delete();
        
        \DB::table('currencies')->insert(array (
            0 => 
            array (
                'id' => 1,
                'image' => 'uploads/currencies/icon_btc.png',
                'coverimage' => 'uploads/currencies/cover_btc.png',
                'name' => 'BTC',
                'displayname' => 'Bitcoin',
                'token' => 'BTC',
                'order' => 4,
                'information' => 'BTC-e was a cryptocurrency trading platform until the U.S. government seized their website. It was founded in July 2011 and as of February 2015 handled around 3% of all Bitcoin exchange volume.[3] Until the 25th of July 2017, it allowed trading between the U. S. dollar, Russian ruble and euro currencies, and the bitcoin, litecoin, namecoin, novacoin, peercoin, dash and ethereum cryptocurrencies.',
                'status' => 0,
                'is_coin' => 1,
                'type' => 'crypto',
                'decimal' => 8,
                'symbol' => NULL,
                'coupon_status' => 1,
                'is_tab' => 1,
                'withdraw_min_amount' => 1,
                'withdraw_max_amount' => 10,
                'token_status' => 1,
                'created_at' => '2018-07-25 10:48:38',
                'updated_at' => '2018-07-25 10:48:38',
            ),
          
         
            1 => 
            array (
                'id' => 2,
                'image' => 'uploads/currencies/icon_ltc.png',
                'coverimage' => 'uploads/currencies/cover_ltc.png',
                'name' => 'LTC',
                'displayname' => 'Lite Coin',
                'token' => 'LTC',
                'order' => 5,
                'information' => 'LTC  is cryptocurrency',
                'status' => 0,
                'is_coin' => 1,
                'type' => 'crypto',
                'decimal' => 2,
                'symbol' => NULL,
                'coupon_status' => 1,
                'is_tab' => 0,
                'withdraw_min_amount' => 1,
                'withdraw_max_amount' => 10,
                'token_status' => 1,
                'created_at' => '2018-07-25 10:48:38',
                'updated_at' => '2018-07-25 10:48:38',
            ),
              2 => 
            array (
                'id' => 3,
                'image' => 'uploads/currencies/icon_doge.png',
                'coverimage' => 'uploads/currencies/cover_doge.png',
                'name' => 'DOGE',
                'displayname' => 'DOGE Coin',
                'token' => 'DOGE',
                'order' => 6,
                'information' => 'DOGE  is cryptocurrency',
                'status' => 0,
                'is_coin' => 1,
                'type' => 'crypto',
                'decimal' => 2,
                'symbol' => NULL,
                'coupon_status' => 1,
                'is_tab' => 0,
                'withdraw_min_amount' => 1,
                'withdraw_max_amount' => 10,
                'token_status' => 1,
                'created_at' => '2018-07-25 10:48:38',
                'updated_at' => '2018-07-25 10:48:38',
            ),
              3 => 
            array (
                'id' => 4,
                'image' => 'uploads/currencies/icon_eth.png',
                'coverimage' => 'uploads/currencies/cover_eth.png',
                'name' => 'ETH',
                'displayname' => 'Ethereum',
                'token' => 'ETH',
                'order' => 7,
                'information' => 'ETH is cryptocurrency',
                'status' => 0,
                'is_coin' => 1,
                'type' => 'crypto',
                'decimal' => 2,
                'symbol' => NULL,
                'coupon_status' => 1,
                'is_tab' => 1,
                'withdraw_min_amount' => 1,
                'withdraw_max_amount' => 10,
                'token_status' => 1,
                'created_at' => '2018-07-25 10:48:38',
                'updated_at' => '2018-07-25 10:48:38',
            ),
         
            4 => 
            array (
                'id' => 5,
                'image' => 'uploads/currencies/icon_usd.png',
                'coverimage' => 'uploads/currencies/cover_usd.png',
                'name' => 'USD',
                'displayname' => 'USD',
                'token' => 'USD',
                'order' => 1,
                'information' => 'USD',
                'status' => 1,
                'is_coin' => 0,
                'type' => 'fiat',
                'decimal' => NULL,
                'symbol' => '$',
                'coupon_status' => 0,
                'is_tab' => 1,
                'withdraw_min_amount' => 1,
                'withdraw_max_amount' => 100,
                'token_status' => 1,
                'created_at' => '2018-07-25 10:48:38',
                'updated_at' => '2018-07-25 10:48:38',
            ),

            5 => 
            array (
                'id' => 6,
                'image' => 'uploads/currencies/icon_euro.png',
                'coverimage' => 'uploads/currencies/cover_euro.png',
                'name' => 'EUR',
                'displayname' => 'EUR',
                'token' => 'EUR',
                'order' => 2,
                'information' => 'EUR',
                'status' => 1,
                'is_coin' => 0,
                'type' => 'fiat',
                'decimal' => NULL,
                'symbol' => '£',
                'coupon_status' => 0,
                'is_tab' => 1,
                'withdraw_min_amount' => 1,
                'withdraw_max_amount' => 10000,
                'token_status' => 1,
                'created_at' => '2018-07-25 10:48:38',
                'updated_at' => '2018-07-25 10:48:38',
            ),
               6 => 
            array (
                'id' => 7,
               'image' => 'uploads/currencies/icon_pound.png',
               'coverimage' => 'uploads/currencies/cover_pound.png',
                'name' => 'GBP',
                'displayname' => 'GBP',
                'token' => 'GBP',
                'order' => 3,
                'information' => 'GBP',
                'status' => 1,
                'is_coin' => 0,
                'type' => 'fiat',
                'decimal' => NULL,
                'symbol' => '£',
                'coupon_status' => 0,
                'is_tab' => 1,
                'withdraw_min_amount' => 1,
                'withdraw_max_amount' => 10000,
                'token_status' => 1,
                'created_at' => '2018-07-25 10:48:38',
                'updated_at' => '2018-07-25 10:48:38',
            ),
           
        ));
        
        
    }
}

  
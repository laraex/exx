<?php

use Illuminate\Database\Seeder;

class CurrencyMasterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currency_master')->insert(
            [

                'name' => "USD",
                'symbol' => "USD",
                'status' => 'used',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );
        DB::table('currency_master')->insert(
            [

                'name' => "BTC",
                'symbol' => "BTC",
                'status' => 'used',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );
        DB::table('currency_master')->insert(
            [

                'name' => "LTC",
                'symbol' => "LTC",
                'status' => 'used',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );
        DB::table('currency_master')->insert(
            [

                'name' => "DOGE",
                'symbol' => "DOGE",
                'status' => 'unused',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );

        DB::table('currency_master')->insert(
            [

                'name' => "AUD",
                'symbol' => "AUD",
                'status' => 'unused',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );

        DB::table('currency_master')->insert(
            [

                'name' => "BRL",
                'symbol' => "BRL",
                'status' => 'unused',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );

        DB::table('currency_master')->insert(
            [
                'name' => "CAD",
                'symbol' => "CAD",
                'status' => 'unused',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );

        DB::table('currency_master')->insert(
            [

                'name' => "CHF",
                'symbol' => "CHF",
                'status' => 'unused',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );

        DB::table('currency_master')->insert(
            [

                'name' => "CLP",
                'symbol' => "CLP",
                'status' => 'unused',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );

        DB::table('currency_master')->insert(
            [
                'name' => "CNY",
                'symbol' => "CNY",
                'status' => 'unused',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );

        DB::table('currency_master')->insert(
            [

                'name' => "CZK",
                'symbol' => "CZK",
                'status' => 'unused',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );

        DB::table('currency_master')->insert(
            [

                'name' => "DKK",
                'symbol' => "DKK",
                'status' => 'unused',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );

        DB::table('currency_master')->insert(
            [

                'name' => "EUR",
                'symbol' => "EUR",
                'status' => 'used',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );

        DB::table('currency_master')->insert(
            [

                'name' => "GBP",
                'symbol' => "GBP",
                'status' => 'unused',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );

        DB::table('currency_master')->insert(
            [

                'name' => "HKD",
                'symbol' => "HKD",
                'status' => 'unused',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );

        DB::table('currency_master')->insert(
            [

                'name' => "HUF",
                'symbol' => "HUF",
                'status' => 'unused',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );

        DB::table('currency_master')->insert(
            [

                'name' => "IDR",
                'symbol' => "IDR",
                'status' => 'unused',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );

        DB::table('currency_master')->insert(
            [

                'name' => "ILS",
                'symbol' => "ILS",
                'status' => 'unused',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );

        DB::table('currency_master')->insert(
            [

                'name' => "INR",
                'symbol' => "INR",
                'status' => 'unused',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );

        DB::table('currency_master')->insert(
            [

                'name' => "JPY",
                'symbol' => "JPY",
                'status' => 'used',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );

        DB::table('currency_master')->insert(
            [

                'name' => "KRW",
                'symbol' => "KRW",
                'status' => 'used',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );

        DB::table('currency_master')->insert(
            [

                'name' => "MXN",
                'symbol' => "MXN",
                'status' => 'unused',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );

        DB::table('currency_master')->insert(
            [

                'name' => "MYR",
                'symbol' => "MYR",
                'status' => 'unused',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );

        DB::table('currency_master')->insert(
            [

                'name' => "NOK",
                'symbol' => "NOK",
                'status' => 'unused',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );

        DB::table('currency_master')->insert(
            [

                'name' => "NZD",
                'symbol' => "NZD",
                'status' => 'unused',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );

        DB::table('currency_master')->insert(
            [

                'name' => "PHP",
                'symbol' => "PHP",
                'status' => 'unused',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );

        DB::table('currency_master')->insert(
            [

                'name' => "PKR",
                'symbol' => "PKR",
                'status' => 'unused',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );

        DB::table('currency_master')->insert(
            [

                'name' => "PLN",
                'symbol' => "PLN",
                'status' => 'unused',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );

        DB::table('currency_master')->insert(
            [

                'name' => "RUB",
                'symbol' => "RUB",
                'status' => 'unused',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );

        DB::table('currency_master')->insert(
            [

                'name' => "SEK",
                'symbol' => "SEK",
                'status' => 'unused',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );

        DB::table('currency_master')->insert(
            [

                'name' => "SGD",
                'symbol' => "SGD",
                'status' => 'unused',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );

        DB::table('currency_master')->insert(
            [

                'name' => "THB",
                'symbol' => "THB",
                'status' => 'unused',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );

        DB::table('currency_master')->insert(
            [

                'name' => "TRY",
                'symbol' => "TRY",
                'status' => 'unused',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );

        DB::table('currency_master')->insert(
            [

                'name' => "TWD",
                'symbol' => "TWD",
                'status' => 'unused',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );

        DB::table('currency_master')->insert(
            [

                'name' => "ZAR",
                'symbol' => "ZAR",
                'status' => 'unused',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );

        DB::table('currency_master')->insert(
            [

                'name' => "NGN",
                'symbol' => "NGN",
                'status' => 'unused',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );
        DB::table('currency_master')->insert(
            [

                'name' => "BCH",
                'symbol' => "BCH",
                'status' => 'used',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );
        DB::table('currency_master')->insert(
            [

                'name' => "XRP",
                'symbol' => "XRP",
                'status' => 'used',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );
        DB::table('currency_master')->insert(
            [

                'name' => "ICX",
                'symbol' => "ICX",
                'status' => 'used',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );
        DB::table('currency_master')->insert(
            [

                'name' => "EOS",
                'symbol' => "EOS",
                'status' => 'used',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );
        DB::table('currency_master')->insert(
            [

                'name' => "ADA",
                'symbol' => "ADA",
                'status' => 'used',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );
        DB::table('currency_master')->insert(
            [

                'name' => "QTUM",
                'symbol' => "QTUM",
                'status' => 'used',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );
        DB::table('currency_master')->insert(
            [

                'name' => "ETC",
                'symbol' => "ETC",
                'status' => 'used',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );
        DB::table('currency_master')->insert(
            [

                'name' => "ETH",
                'symbol' => "ETH",
                'status' => 'used',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );
        DB::table('currency_master')->insert(
            [

                'name' => "TRX",
                'symbol' => "TRX",
                'status' => 'used',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );
        DB::table('currency_master')->insert(
            [

                'name' => "GNT",
                'symbol' => "GNT",
                'status' => 'used',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );
        DB::table('currency_master')->insert(
            [

                'name' => "BNT",
                'symbol' => "BNT",
                'status' => 'used',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );

        DB::table('currency_master')->insert(
            [

                'name' => "LOOM",
                'symbol' => "LOOM",
                'status' => 'used',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );
        DB::table('currency_master')->insert(
            [

                'name' => "SALT",
                'symbol' => "SALT",
                'status' => 'used',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );
        DB::table('currency_master')->insert(
            [

                'name' => "DAI",
                'symbol' => "DAI",
                'status' => 'used',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );
        DB::table('currency_master')->insert(
            [

                'name' => "ANT",
                'symbol' => "ANT",
                'status' => 'used',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );
        DB::table('currency_master')->insert(
            [

                'name' => "ZIL",
                'symbol' => "ZIL",
                'status' => 'used',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );
    }
}

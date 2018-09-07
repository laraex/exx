<?php

use Illuminate\Database\Seeder;

class TradeCurrencyPairTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('trade_currency_pair')->insert([
            'from_currency_id' => "1",
            'to_currency_id' => "5",
            'status' => 'active',
            'min_value' => 0.02,
            'max_value' => 1.0,
            'buy_fee' => 0.5,
            'buy_base_fee' => 0,
            'sell_fee' => 0.5,
            'sell_base_fee' => 0,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('trade_currency_pair')->insert(
            [

                'from_currency_id' => "2",
                'to_currency_id' => "5",
                'status' => 'active',
                'min_value' => 0.02,
                'max_value' => 1.0,

                'buy_fee' => 0.5,
                'buy_base_fee' => 0,
                'sell_fee' => 0.5,
                'sell_base_fee' => 0,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );

        DB::table('trade_currency_pair')->insert(
            [

                'from_currency_id' => "3",
                'to_currency_id' => "5",
                'status' => 'active',
                'min_value' => 0.02,
                'max_value' => 1.0,
                'buy_fee' => 0.5,
                'buy_base_fee' => 0,
                'sell_fee' => 0.5,
                'sell_base_fee' => 0,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );
        DB::table('trade_currency_pair')->insert(
            [

                'from_currency_id' => "4",
                'to_currency_id' => "5",
                'status' => 'active',
                'min_value' => 0.02,
                'max_value' => 1.0,

                'buy_fee' => 0.5,
                'buy_base_fee' => 0,
                'sell_fee' => 0.5,
                'sell_base_fee' => 0,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );
       
        
        DB::table('trade_currency_pair')->insert(
            [

                'from_currency_id' => "1",
                'to_currency_id' => "6",
                'status' => 'active',
                'min_value' => 0.0001,
                'max_value' => 1.0,

                'buy_fee' => 0.5,
                'buy_base_fee' => 0,
                'sell_fee' => 0.5,
                'sell_base_fee' => 0,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );

        DB::table('trade_currency_pair')->insert([
            'from_currency_id' => "2",
            'to_currency_id' => "6",
            'status' => 'active',
            'min_value' => 0.02,
            'max_value' => 1.0,
            'buy_fee' => 0.5,
            'buy_base_fee' => 0,
            'sell_fee' => 0.5,
            'sell_base_fee' => 0,

            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('trade_currency_pair')->insert(
            [

                'from_currency_id' => "3",
                'to_currency_id' => "6",
                'status' => 'active',
                'min_value' => 0.02,
                'max_value' => 1.0,
                'buy_fee' => 0.5,
                'buy_base_fee' => 0,
                'sell_fee' => 0.5,
                'sell_base_fee' => 0,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );

        DB::table('trade_currency_pair')->insert(
            [

                'from_currency_id' => "4",
                'to_currency_id' => "6",
                'status' => 'active',
                'min_value' => 0.02,
                'max_value' => 1.0,
                'buy_fee' => 0.5,
                'buy_base_fee' => 0,
                'sell_fee' => 0.5,
                'sell_base_fee' => 0,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );
       
        
        DB::table('trade_currency_pair')->insert(
            [

                'from_currency_id' => "1",
                'to_currency_id' => "7",
                'status' => 'active',
                'min_value' => 1.0,
                'max_value' => 100.0,
                'buy_fee' => 0.5,
                'buy_base_fee' => 0,
                'sell_fee' => 0.5,
                'sell_base_fee' => 0,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );
        DB::table('trade_currency_pair')->insert(
            [

                'from_currency_id' => "2",
                'to_currency_id' => "7",
                'status' => 'active',
                'min_value' => 1.0,
                'max_value' => 100.0,
                'buy_fee' => 0.5,
                'buy_base_fee' => 0,
                'sell_fee' => 0.5,
                'sell_base_fee' => 0,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );

        DB::table('trade_currency_pair')->insert([
            'from_currency_id' => "3",
            'to_currency_id' => "7",
            'status' => 'active',
            'min_value' => 0.02,
            'max_value' => 1.0,

            'buy_fee' => 0.5,
            'buy_base_fee' => 0,
            'sell_fee' => 0.5,
            'sell_base_fee' => 0,

            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('trade_currency_pair')->insert(
            [

                'from_currency_id' => "4",
                'to_currency_id' => "7",
                'status' => 'active',
                'min_value' => 0.02,
                'max_value' => 1.0,
                'buy_fee' => 0.5,
                'buy_base_fee' => 0,
                'sell_fee' => 0.5,
                'sell_base_fee' => 0,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );


      

        DB::table('trade_currency_pair')->insert(
            [

                'from_currency_id' => "2",
                'to_currency_id' => "1",
                'status' => 'active',
                'min_value' => 1.0,
                'max_value' => 100.0,

                'buy_fee' => 0.5,
                'buy_base_fee' => 0,
                'sell_fee' => 0.5,
                'sell_base_fee' => 0,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );
        DB::table('trade_currency_pair')->insert(
            [

                'from_currency_id' => "3",
                'to_currency_id' => "1",
                'status' => 'active',
                'min_value' => 1.0,
                'max_value' => 100.0,

                'buy_fee' => 0.5,
                'buy_base_fee' => 0,
                'sell_fee' => 0.5,
                'sell_base_fee' => 0,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );

        DB::table('trade_currency_pair')->insert(
            [

                'from_currency_id' => "4",
                'to_currency_id' => "1",
                'status' => 'active',
                'min_value' => 1.0,
                'max_value' => 100.0,

                'buy_fee' => 0.5,
                'buy_base_fee' => 0,
                'sell_fee' => 0.5,
                'sell_base_fee' => 0,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );

        DB::table('trade_currency_pair')->insert(
            [

                'from_currency_id' => "2",
                'to_currency_id' => "4",
                'status' => 'active',
                'min_value' => 1.0,
                'max_value' => 100.0,
                'buy_fee' => 0.5,
                'buy_base_fee' => 0,
                'sell_fee' => 0.5,
                'sell_base_fee' => 0,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );

        DB::table('trade_currency_pair')->insert(
            [

                'from_currency_id' => "3",
                'to_currency_id' => "4",
                'status' => 'active',
                'min_value' => 1.0,
                'max_value' => 100.0,

                'buy_fee' => 0.5,
                'buy_base_fee' => 0,
                'sell_fee' => 0.5,
                'sell_base_fee' => 0,

                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );

       
    }
}

<?php

use Illuminate\Database\Seeder;

class UsercurrencyaccountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        DB::table('usercurrencyaccounts')->insert(
        [
            'account_no' => "A-BTC-10001",
            'user_id' => "1",
            'currency_id' => "1",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),  
        ]);
        DB::table('usercurrencyaccounts')->insert(
        [
            'account_no' => "A-LTC-10001",
            'user_id' => "1",
            'currency_id' => "2",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),  
        ]);
        DB::table('usercurrencyaccounts')->insert(
        [
            'account_no' => "A-DOGE-10001",
            'user_id' => "1",
            'currency_id' => "2",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),  
        ]);
        DB::table('usercurrencyaccounts')->insert(
        [
            'account_no' => "A-EUR-10001",
            'user_id' => "1",
            'currency_id' => "6",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),  
        ]);

        DB::table('usercurrencyaccounts')->insert(
        [
            'account_no' => "A-USD-10001",
            'user_id' => "1",
            'currency_id' => "5",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),      
        ]);
        DB::table('usercurrencyaccounts')->insert(
        [
            'account_no' => "A-GBP-10001",
            'user_id' => "1",
            'currency_id' => "7",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),      
        ]);


        DB::table('usercurrencyaccounts')->insert(
        [
            'account_no' => "A-EUR-10006",
            'user_id' => "6",
            'currency_id' => "6",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),      
        ]);

        DB::table('usercurrencyaccounts')->insert(
        [
            'account_no' => "A-USD-10006",
            'user_id' => "6",
            'currency_id' => "5",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),      
        ]);
         DB::table('usercurrencyaccounts')->insert(
        [
            'account_no' => "A-GBP-10006",
            'user_id' => "6",
            'currency_id' => "7",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),      
        ]);

         DB::table('usercurrencyaccounts')->insert(
        [
            'account_no' => "A-EUR-10007",
            'user_id' => "7",
            'currency_id' => "6",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),  
        ]);

     
        DB::table('usercurrencyaccounts')->insert(
        [
            'account_no' => "A-USD-10007",
            'user_id' => "7",
            'currency_id' => "5",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),      
        ]);
          DB::table('usercurrencyaccounts')->insert(
        [
            'account_no' => "A-GBP-10007",
            'user_id' => "5",
            'currency_id' => "7",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),      
        ]);
        
        // DB::table('usercurrencyaccounts')->insert(
        // [
        //     'account_no' => "A-GBP-10001",
        //     'user_id' => "1",
        //     'currency_id' => "5",
        //     'created_at' => date("Y-m-d H:i:s"),
        //     'updated_at' => date("Y-m-d H:i:s"),    
        // ]);       
        // DB::table('usercurrencyaccounts')->insert(
        // [
        //     'account_no' => "A-EURO-10001",
        //     'user_id' => "1",
        //     'currency_id' => "6",
        //     'created_at' => date("Y-m-d H:i:s"),
        //     'updated_at' => date("Y-m-d H:i:s"),  
        // ]);
        // DB::table('usercurrencyaccounts')->insert(
        // [
        //     'account_no' => "A-NGN-10001",
        //     'user_id' => "1",
        //     'currency_id' => "7",
        //     'created_at' => date("Y-m-d H:i:s"),
        //     'updated_at' => date("Y-m-d H:i:s"),    
        // ]);
        
          


       
        
        
    }
}
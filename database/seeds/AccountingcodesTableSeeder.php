<?php

use Illuminate\Database\Seeder;

class AccountingcodesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {       
        /*DB::table('accountingcodes')->insert(
        [
            'accounting_code' => "deposit-via-banktransfer",
            'active' => "1",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);       
        DB::table('accountingcodes')->insert(
        [
            'accounting_code' => "deposit-via-perfectmoney",
            'active' => "1",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);
        DB::table('accountingcodes')->insert(
        [
            'accounting_code' => "deposit-via-bitcoin",
            'active' => "1",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);       
      */
        DB::table('accountingcodes')->insert(
        [
            'accounting_code' => "withdraw-via-bankwire",
            'active' => "1",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

        DB::table('accountingcodes')->insert(
        [
            'accounting_code' => "withdraw-via-perfectmoney",
            'active' => "1",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);
      
        DB::table('accountingcodes')->insert(
        [
            'accounting_code' => "withdraw-via-bitcoin",
            'active' => "1",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);      
        DB::table('accountingcodes')->insert(
        [
            'accounting_code' => "withdraw-cancellation",
            'active' => "1",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);
        DB::table('accountingcodes')->insert(
        [
            'accounting_code' => "withdraw-commission",
            'active' => "1",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);       
       
       
        DB::table('accountingcodes')->insert(
        [
            'accounting_code' => "fund-transfer",
            'active' => "1",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);
        DB::table('accountingcodes')->insert(
        [
            'accounting_code' => "fund-transfer-commission",
            'active' => "1",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);       
     
        DB::table('accountingcodes')->insert(
        [
            'accounting_code' => "fund-added",
            'active' => "1",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]); 

        DB::table('accountingcodes')->insert(
        [
            'accounting_code' => "fund-exchange",
            'active' => "1",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]); 

        DB::table('accountingcodes')->insert(
        [
            'accounting_code' => "fund-exchange-commission",
            'active' => "1",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);       
             
       /* DB::table('accountingcodes')->insert(
        [
            'accounting_code' => "NGN-admin-user-debit-buy-giftcard",
            'active' => "1",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);*/
        /* DB::table('accountingcodes')->insert(
        [
            'accounting_code' => "NGN-admin-user-credit-buy-giftcard-wallet",
            'active' => "1",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);*/


         DB::table('accountingcodes')->insert(
        [
            'accounting_code' => "external-exchange-credit",
            'active' => "1",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);
          DB::table('accountingcodes')->insert(
        [
            'accounting_code' => "USD-admin-user-debit-buy-giftcard",
            'active' => "1",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);
          DB::table('accountingcodes')->insert(
        [
            'accounting_code' => "USD-admin-user-credit-buy-giftcard-wallet",
            'active' => "1",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);
       
        DB::table('accountingcodes')->insert(
        [
            'accounting_code' => "BTC-commission-buy",
            'active' => "1",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);
        DB::table('accountingcodes')->insert(
        [
            'accounting_code' => "BTC-buy-debit-wallet",
            'active' => "1",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);
        DB::table('accountingcodes')->insert(
        [
            'accounting_code' => "LTC-commission-buy",
            'active' => "1",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);
        DB::table('accountingcodes')->insert(
        [
            'accounting_code' => "LTC-buy-debit-wallet",
            'active' => "1",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);
        DB::table('accountingcodes')->insert(
        [
            'accounting_code' => "external-exchange-fee",
            'active' => "1",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);
        DB::table('accountingcodes')->insert(
        [
            'accounting_code' => "DOGE-commission-buy",
            'active' => "1",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);
        DB::table('accountingcodes')->insert(
        [
            'accounting_code' => "DOGE-buy-debit-wallet",
            'active' => "1",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

       
        DB::table('accountingcodes')->insert(
        [
            'accounting_code' => "trade-sell-debit",
            'active' => "1",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

         DB::table('accountingcodes')->insert(
        [
            'accounting_code' => "trade-buy-debit",
            'active' => "1",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);
          DB::table('accountingcodes')->insert(
        [
            'accounting_code' => "trade-sell-credit",
            'active' => "1",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

         DB::table('accountingcodes')->insert(
        [
            'accounting_code' => "trade-buy-credit",
            'active' => "1",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);
         DB::table('accountingcodes')->insert(
        [
            'accounting_code' => "deposit-bank-USD",
            'active' => "1",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);
         DB::table('accountingcodes')->insert(
        [
            'accounting_code' => "deposit-bank-KRW",
            'active' => "1",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);
         
         DB::table('accountingcodes')->insert(
        [
            'accounting_code' => "transfer",
            'active' => "1",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);
          DB::table('accountingcodes')->insert(
        [
            'accounting_code' => "settlement",
            'active' => "1",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);

        DB::table('accountingcodes')->insert(
        [
            'accounting_code' => "crypto-withdraw-cancel-credit",
            'active' => "1",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);
          DB::table('accountingcodes')->insert(
        [
            'accounting_code' => "deposit-bank-EURO",
            'active' => "1",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);
           DB::table('accountingcodes')->insert(
        [
            'accounting_code' => "deposit-bank-GBP",
            'active' => "1",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);
        

    }
}

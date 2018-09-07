<?php

use Illuminate\Database\Seeder;

class PaymentgatewaysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('paymentgateways')->insert([
            'gatewayname' => 'bitcoin',
            'displayname' => 'Bitcoin via Direct Wallet Transfer',
            'active' => '0',
            'currency_id' => '1',
            'withdraw' => '0',
            'exchange' => '0',            
            'params' => '{"address":"19356KxTs9Bw5AAdxens5hoxDSp5bsUKse"}',
            'instructions' => 'some instruction text',
            
            ]);     

        DB::table('paymentgateways')->insert([
        	'gatewayname' => 'bank-USD',
        	'displayname' => 'Bank Transfer USD',
        	'active' => '1',
            'currency_id' => '5',
        	'withdraw' => '1',
        	'exchange' => '1',           
        	'params' => '{"bank_name":"Bank of USD", "bank_address":"Madurai", "swift_code":"435435435", "account_name":"Tester", "account_no":"0987654321"}',
        	'instructions' => 'some instruction text',
        	]);

        DB::table('paymentgateways')->insert([
            'gatewayname' => 'bank-GBP',
            'displayname' => 'Bank Transfer GBP',
            'active' => '1',
            'currency_id' => '7',
            'withdraw' => '1',
            'exchange' => '1',          
            'params' => '{"bank_name":"Bank of GBP", "bank_address":"Madurai", "swift_code":"435435435", "account_name":"Tester", "account_no":"0987654321"}',
            'instructions' => 'some instruction text',
            ]); 


        DB::table('paymentgateways')->insert([
            'gatewayname' => 'bank-EURO',
            'displayname' => 'Bank Transfer EURO',
            'active' => '1',
            'currency_id' => '6',
            'withdraw' => '1',
            'exchange' => '1',          
            'params' => '{"bank_name":"Bank of EURO", "bank_address":"Madurai", "swift_code":"435435435", "account_name":"Tester", "account_no":"0987654321"}',
            'instructions' => 'some instruction text',
            ]);   

        /*DB::table('paymentgateways')->insert([
            'gatewayname' => 'bank-NGN',
            'displayname' => 'Bank Transfer NGN',
            'active' => '1',
            'currency_id' => '7',
            'withdraw' => '1',
            'exchange' => '1',          
            'params' => '{"bank_name":"Bank of NGN", "bank_address":"Madurai", "swift_code":"435435435", "account_name":"Tester", "account_no":"0987654321"}',
            'instructions' => 'some instruction text',
        ]);     
           
        DB::table('paymentgateways')->insert([
            'gatewayname' => 'perfectmoney',
            'displayname' => 'PerfectMoney',
            'active' => '1',
            'currency_id' => '4',
            'withdraw' => '0',
            'exchange' => '0',           
            'params' => '{"payee_account":"U9007123","payee_name":"exchanger","alternate_passhprase":"test"}',
            'instructions' => 'some instruction text about PerfectMoney',
        ]);
                 
        DB::table('paymentgateways')->insert([
            'gatewayname' => 'paypal',
            'displayname' => 'Paypal',
            'active' => '1',
            'currency_id' => '4',
            'withdraw' => '0',
            'exchange' => '0',         
            'params' => '{"merchant_email":"sundari1@gegosoft.com", "mode":"sandbox"}',
            'instructions' => 'Pay with Paypal',
        ]);

        DB::table('paymentgateways')->insert([
            'gatewayname' => 'skrill',
            'displayname' => 'Skrill',
            'active' => '1',
            'currency_id' => '4',
            'withdraw' => '0',
            'exchange' => '0',          
            'params' => '{"pay_to_email":"admin@hyip.com"}',
            'instructions' => 'some instruction text',
        ]);

        DB::table('paymentgateways')->insert([
            'gatewayname' => 'neteller',
            'displayname' => 'Neteller',
            'active' => '1',
            'currency_id' => '4',
            'withdraw' => '0',
            'exchange' => '0',            
            'params' => '{"merchant_id":"432156789012","merch_key":"123456","paymentmode":"test"}',
            'instructions' => 'some instruction text about Neteller',
        ]);
*/
        DB::table('paymentgateways')->insert([
            'gatewayname' => 'bitcoin_blockio',
            'displayname' => 'Bitcoin ',
            'active' => '0',
            'currency_id' => '1',
            'withdraw' => '0',
            'exchange' => '0',          
            'params' => '',
            'instructions' => 'some instruction text',
            'crypto_withdraw_fee' => '0',
            'crypto_withdraw_base_fee' => '0.0001',
        ]);
        
        DB::table('paymentgateways')->insert([
            'gatewayname' => 'ltc_blockio',
            'displayname' => 'LTC ',
            'active' => '1',
            'currency_id' => '2',
            'withdraw' => '0',
            'exchange' => '0',         
            'params' => '',
            'instructions' => 'some instruction text',
            'crypto_withdraw_fee' => '0',
            'crypto_withdraw_base_fee' => '0.0001',
        ]);

        DB::table('paymentgateways')->insert([
            'gatewayname' => 'dogecoin_blockio',
            'displayname' => 'Dogecoin via BlockIO',
            'active' => '1',
            'currency_id' => '3',
            'withdraw' => '0',
            'exchange' => '0',         
            'params' => '{"api_key":"7ac4-2f33-ec69-b61a", "pin":"gegosoft","version":"2", "doge_address":"2N9JbdvZF8qy94SQgisZ6FUiXokgwDBJjj1","mode":"DOGETEST"}',
            'instructions' => 'some instruction text',
        ]);

            DB::table('paymentgateways')->insert([
            'gatewayname' => 'eth',
            'displayname' => 'Ethereum',
            'active' => '1',
            'currency_id' => '4',
            'withdraw' => '0',
            'exchange' => '0',         
            'params' => '',
            'instructions' => 'some instruction text',
            'crypto_withdraw_fee' => '0',
            'crypto_withdraw_base_fee' => '0.0001',
         
        ]);
         
    }
}

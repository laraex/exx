<?php

use Illuminate\Database\Seeder;

class CurrencyPairTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

         DB::table('currency_pair')->insert([
            'from_currency_id' => "1",
            'to_currency_id' => "2",
            'status' => 'active',
            'min_amount' => 0.02,
            'max_amount' => 1.0,
            'fee' => 0.5,
            'base_fee' => 10,   
            'type' => 'fiat',                 
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
         DB::table('currency_pair')->insert(
        [
            
            'from_currency_id' => "1",
            'to_currency_id' => "3",
            'status' => 'active',
            'min_amount' => 0.02,
            'max_amount' => 1.0,
            'fee' => 0.5,
            'base_fee' => 10, 
            'type' => 'fiat',                       
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('currency_pair')->insert(
        [
            
            'from_currency_id' => "1",
            'to_currency_id' => "4",
            'status' => 'active',
            'min_amount' => 0.02,
            'max_amount' => 1.0,
            'fee' => 0.5,
            'base_fee' => 10, 
            'type' => 'fiat',                       
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
         DB::table('currency_pair')->insert(
        [
            
            'from_currency_id' => "5",
            'to_currency_id' => "1",
            'min_amount' => 0.02,
            'max_amount' => 1.0,
            'fee' => 0.5,
            'base_fee' => 100, 
            'type' => 'fiat',                 
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

         DB::table('currency_pair')->insert(
        [
            
            'from_currency_id' => "5",
            'to_currency_id' => "2",
            'status' => 'active',
            'min_amount' => 1.0,
            'max_amount' => 100.0,
            'fee' => 0.5,
            'base_fee' => 10,  
            'type' => 'fiat',                      
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
         DB::table('currency_pair')->insert(
        [
            
            'from_currency_id' => "5",
            'to_currency_id' => "3",
            'status' => 'active',
            'min_amount' => 1.0,
            'max_amount' => 100.0,  
            'fee' => 0.5,
            'base_fee' => 10,
            'type' => 'fiat',                  
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]); 
         DB::table('currency_pair')->insert(
        [
            
            'from_currency_id' => "5",
            'to_currency_id' => "4",
            'status' => 'active',
            'min_amount' => 1.0,
            'max_amount' => 100.0,
            'fee' => 0.5,
            'base_fee' => 10, 
            'type' => 'fiat',                
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
         DB::table('currency_pair')->insert(
        [
            
            'from_currency_id' => "6",
            'to_currency_id' => "1",
            'min_amount' => 1.0,
            'max_amount' => 100.0, 
            'fee' => 0.5,
            'base_fee' => 100,
            'type' => 'fiat',                  
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

         DB::table('currency_pair')->insert(
        [
            
            'from_currency_id' => "6",
            'to_currency_id' => "2",
            'status' => 'inactive',
            'min_amount' => 1.0,
            'max_amount' => 100.0,
            'fee' => 0.5,
            'base_fee' => 10,   
            'type' => 'fiat',               
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
         DB::table('currency_pair')->insert(
        [
            
            'from_currency_id' => "6",
            'to_currency_id' => "3",
            'status' => 'inactive',
            'min_amount' => 1.0,
            'max_amount' => 100.0,
            'fee' => 0.5,
            'base_fee' => 10,
            'type' => 'fiat',                  
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]); 
         DB::table('currency_pair')->insert(
        [
            
            'from_currency_id' => "4",
            'to_currency_id' => "2",
            'status' => 'inactive',
            'min_amount' => 1.0,
            'max_amount' => 100.0,
            'fee' => 0.5,
            'base_fee' => 10,  
            'type' => 'fiat',               
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
         DB::table('currency_pair')->insert(
        [
            
            'from_currency_id' => "4",
            'to_currency_id' => "3",
            'min_amount' => 1.0,
            'max_amount' => 100.0,
            'fee' => 0.5,
            'base_fee' => 100,
            'type' => 'fiat',                  
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);


    }
}

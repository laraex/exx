<?php

use Illuminate\Database\Seeder;

class UserInformationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      
        DB::table('user_information')->insert(
        [
            'user_id' => "1",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]); 

        DB::table('user_information')->insert(
        [
            'user_id' => "2",          
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);
        DB::table('user_information')->insert(
        [
            'user_id' => "3",         
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);
        DB::table('user_information')->insert(
        [
            'user_id' => "4",       
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('user_information')->insert(
        [
            'user_id' => "5",           
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}

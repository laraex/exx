<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        DB::table('users')->insert(
        [
            'name' => "admin",
            'email' => "admin@nuxigen.uk",
            'password' => bcrypt("admin"),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]); 

         DB::table('users')->insert(
        [
            'name' => "staff",
            'email' => "staff@nuxigen.uk",
            'password' => bcrypt("staff"),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('users')->insert(
        [
            'name' => "staff1",
            'email' => "staff1@nuxigen.uk",
            'password' => bcrypt("staff1"),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('users')->insert(
        [
            'name' => "staff2",
            'email' => "staff2@nuxigen.uk",
            'password' => bcrypt("staff2"),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]); 

        DB::table('users')->insert(
        [
            'name' => "bank",
            'email' => "bank@nuxigen.uk",
            'password' => bcrypt("bank"),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]); 
        DB::table('users')->insert(
        [
            'name' => "system",
            'email' => "system@nuxigen.uk",
            'password' => bcrypt("system"),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]); 
         DB::table('users')->insert(
        [
            'name' => "tradepot",
            'email' => "tradepot@nuxigen.uk",
            'password' => bcrypt("tradepot"),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);      
    }
}

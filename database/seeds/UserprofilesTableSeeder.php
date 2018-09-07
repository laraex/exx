<?php

use Illuminate\Database\Seeder;

class UserprofilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      
        DB::table('userprofiles')->insert(
        [
            'user_id' => "1",
            'usergroup_id' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]); 

        DB::table('userprofiles')->insert(
        [
            'user_id' => "2",
            'usergroup_id' => 2,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);
        DB::table('userprofiles')->insert(
        [
            'user_id' => "3",
            'usergroup_id' => 2,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);
        DB::table('userprofiles')->insert(
        [
            'user_id' => "4",
            'usergroup_id' => 2,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('userprofiles')->insert(
        [
            'user_id' => "5",
            'usergroup_id' => 2,
            'created_at' => date("Y-m-d H:i:s"),
            
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('userprofiles')->insert(
        [
            'user_id' => "6",
            'usergroup_id' => 3,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('userprofiles')->insert(
        [
            'user_id' => "7",
            'usergroup_id' => 3,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
     
        
    }
}

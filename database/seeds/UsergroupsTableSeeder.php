<?php

use Illuminate\Database\Seeder;

class UsergroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('users')->delete();
        
        DB::table('usergroups')->insert(
        [
            'name' => "admin",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);        

        DB::table('usergroups')->insert(
        [
            'name' => "staff",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('usergroups')->insert(
        [
            'name' => "member",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

       
    }
}

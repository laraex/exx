<?php

use Illuminate\Database\Seeder;

class TicketCategoriesUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ticket_categories_users')->insert(
        [
            'category_id' => "1",
            'user_id' => "2",
            'created_at' => date("Y-m-d H:i:s"),
             'updated_at' => date("Y-m-d H:i:s"),     
        ]);
        DB::table('ticket_categories_users')->insert(
        [
            'category_id' => "2",
            'user_id' => "3",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),  
        ]);
        DB::table('ticket_categories_users')->insert(
        [
            'category_id' => "3",
            'user_id' => "4",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),  
        ]);
        DB::table('ticket_categories_users')->insert(
        [
            'category_id' => "4",
            'user_id' => "4",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),  
        ]);
    }
}

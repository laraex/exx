<?php

use Illuminate\Database\Seeder;

class TicketCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ticket_categories')->insert(
        [
            'name' => "Register",
            'color' => "#0014f4",
            'created_at' => date("Y-m-d H:i:s"),
             'updated_at' => date("Y-m-d H:i:s"),     
        ]);
        DB::table('ticket_categories')->insert(
        [
            'name' => "Buy / Sell",
            'color' => "#2b9900",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),  
        ]);
        DB::table('ticket_categories')->insert(
        [
            'name' => "Exchange",
            'color' => "#7e0099",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),  
        ]);
        DB::table('ticket_categories')->insert(
        [
            'name' => "Exchange",
            'color' => "#4e4e44",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),  
        ]);
       
    }
}

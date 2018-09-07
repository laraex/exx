<?php

use Illuminate\Database\Seeder;

class TicketStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ticket_statuses')->insert(
        [
            'name' => "Pending",
            'color' => "#e69900",
            'created_at' => date("Y-m-d H:i:s"),
             'updated_at' => date("Y-m-d H:i:s"),     
        ]);
        DB::table('ticket_statuses')->insert(
        [
            'name' => "Solved",
            'color' => "#15a000",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),  
        ]);
        DB::table('ticket_statuses')->insert(
        [
            'name' => "Bug",
            'color' => "#f40700",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),  
        ]);
    }
}

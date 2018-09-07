<?php

use Illuminate\Database\Seeder;

class TicketPrioritiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ticket_priorities')->insert(
        [
            'name' => "Low",
            'color' => "#069900",
            'created_at' => date("Y-m-d H:i:s"),
             'updated_at' => date("Y-m-d H:i:s"),     
        ]);
        DB::table('ticket_priorities')->insert(
        [
            'name' => "Normal",
            'color' => "#e1d200",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),  
        ]);
        DB::table('ticket_priorities')->insert(
        [
            'name' => "Critical",
            'color' => "#e10000",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),  
        ]);
       
       
    }
}

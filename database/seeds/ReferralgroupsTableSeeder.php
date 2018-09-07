<?php

use Illuminate\Database\Seeder;

class ReferralgroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('referralgroups')->insert(
        [
            'name' => "Member",
            'referral_commission' => "7.5",
            'level_commission' => '[{"level":"1","commission_value":"5.0"},{"level":"2","commission_value":"4.0"},{"level":"3","commission_value":"3.5"}, {"level":"4","commission_value":"2.5"}, {"level":"5","commission_value":"1.5"}]',
            'active' => 1,
            'is_default' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),     
        ]);

        DB::table('referralgroups')->insert(
        [
            'name' => "Elite Members",
            'referral_commission' => "8.5",
            'level_commission' => '[{"level":"1","commission_value":"6.0"},{"level":"2","commission_value":"5.0"},{"level":"3","commission_value":"4.5"}, {"level":"4","commission_value":"4.0"}, {"level":"5","commission_value":"2.0"}]',
            'active' => 1,
            'is_default' => 0,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),     
        ]);

        DB::table('referralgroups')->insert(
        [
            'name' => "Foundation Members",
            'referral_commission' => "10.0",
            'level_commission' => '[{"level":"1","commission_value":"7.0"},{"level":"2","commission_value":"6.0"},{"level":"3","commission_value":"5.5"}, {"level":"4","commission_value":"5.0"}, {"level":"5","commission_value":"4.5"}]',
            'active' => 1,
            'is_default' => 0,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),     
        ]);
        
        DB::table('referralgroups')->insert(
        [
            'name' => "Board of Directors",
            'referral_commission' => "12.0",
            'level_commission' => '[{"level":"1","commission_value":"7.0"},{"level":"2","commission_value":"6.0"},{"level":"3","commission_value":"5.5"}, {"level":"4","commission_value":"5.0"}, {"level":"5","commission_value":"4.5"}, {"level":"6","commission_value":"4.0"}, {"level":"7","commission_value":"3.5"}, {"level":"8","commission_value":"3.0"}, {"level":"9","commission_value":"2.5"}, {"level":"10","commission_value":"2.0"}, {"level":"11","commission_value":"1.5"}, {"level":"12","commission_value":"1.0"}]',
            'active' => 1,
            'is_default' => 0,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),     
        ]);
    }
}

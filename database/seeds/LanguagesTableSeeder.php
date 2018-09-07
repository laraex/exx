<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('languages')->insert([
            'name'        => 'English',
            'app_name'    => 'english',
            'flag'        => '',
            'abbr'        => 'en',
            'script'    => 'Latn',
            'native'    => 'English',
            'active'    => '1',
            'default'    => '1',
        ]);
      
        DB::table('languages')->insert([
            'name'        => 'Korean',
            'app_name'    => 'korean',
            'flag'        => '',
            'abbr'        => 'ko',
            'script'    => 'Latn',
            'native'    => '한국어',
            'active'    => '1',
            'default'    => '0',
        ]);

        // $this->command->info('Language seeding successful.');
    }
}

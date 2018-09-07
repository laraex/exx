<?php

use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pages')->insert(
        [
            'title' => "How it Works",
            'description' => "How it Works Description",
            'navlabel' => "How it Works",
            'slug' => "how-it-works",
            'content' => "How it Works Content Comes Here.",
            'seotitle' => "Larahyip How it Works",
            'language'=>'en',
            'seodescription' => "Larahyip How it Works",
            'seokeyword' => "Larahyip How it Works",
            'active'        => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),     
        ]);
        
    }
}

<?php

use Illuminate\Database\Seeder;

class FaqsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('faqs')->insert(
        [
            'title' => "Question 1 here?",
            'description' => "Lorem Ipsum is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. ",
            'order'        => 1,
            'language'        => 'en',
            'active'        => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),     
        ]);
        DB::table('faqs')->insert(
        [
            'title' => "Question 2 here?",
            'description' => "Lorem Ipsum is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. ",
            'order'        => 2,
             'language'        => 'en',
            'active'        => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);
        DB::table('faqs')->insert(
        [
            'title' => "Question 3 here?",
            'description' => "Lorem Ipsum is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. ",
            'order'        => 3,
             'language'        => 'en',
            'active'        => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);
        DB::table('faqs')->insert(
        [
            'title' => "Question 4 here?",
            'description' => "Lorem Ipsum is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. ",
            'order'        => 3,
             'language'        => 'en',
            'active'        => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);
        DB::table('faqs')->insert(
        [
            'title' => "Question 5 here?",
            'description' => "Lorem Ipsum is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. ",
            'order'        => 3,
             'language'        => 'en',
            'active'        => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);
        DB::table('faqs')->insert(
        [
            'title' => "Question 6 here?",
            'description' => "Lorem Ipsum is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. ",
            'order'        => 3,
            'active'        => 1,
             'language'        => 'en',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);
        DB::table('faqs')->insert(
        [
            'title' => "Question 7 here?",
            'description' => "Lorem Ipsum is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. ",
            'order'        => 3,
             'language'        => 'en',
            'active'        => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),    
        ]);
    }
}

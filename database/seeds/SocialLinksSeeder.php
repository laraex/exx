<?php

use Illuminate\Database\Seeder;

class SocialLinksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sociallinks')->insert(
        [
            'title' => "facebook",
            'icon' => '<i class="fa fa-facebook" aria-hidden="true"></i>',
            'link' => "https://www.facebook.com/",   
            'status' => "active",
            'order' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),     
        ]);

        DB::table('sociallinks')->insert(
        [
            'title' => "Twitter",
            'icon' => '<i class="fa fa-twitter-square" aria-hidden="true"></i>',
            'link' => "https://twitter.com/",   
            'status' => "active",
            'order' => 2,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),     
        ]);

        DB::table('sociallinks')->insert(
        [
            'title' => "YouTube",
            'icon' => '<i class="fa fa-youtube" aria-hidden="true"></i>',
            'link' => "https://www.youtube.com/",   
            'status' => "active",
            'order' => 3,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),     
        ]);

        DB::table('sociallinks')->insert(
        [
            'title' => "Linkedin",
            'icon' => '<i class="fa fa-linkedin" aria-hidden="true"></i>',
            'link' => "https://www.linkedin.com/",   
            'status' => "active",
            'order' => 4,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),     
        ]);

        DB::table('sociallinks')->insert(
        [
            'title' => "Google+",
            'icon' => '<i class="fa fa-google-plus" aria-hidden="true"></i>',
            'link' => "https://plus.google.com/discover",   
            'status' => "active",
            'order' => 5,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),     
        ]);

        DB::table('sociallinks')->insert(
        [
            'title' => "Instagram",
            'icon' => '<i class="fa fa-instagram" aria-hidden="true"></i>',
            'link' => "https://www.instagram.com/",   
            'status' => "active",
            'order' => 6,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),     
        ]);

        DB::table('sociallinks')->insert(
        [
            'title' => "Pinterest",
            'icon' => '<i class="fab fa-pinterest aria-hidden="true></i>',
            'link' => "https://in.pinterest.com/",   
            'status' => "active",
            'order' => 7,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),     
        ]);

        DB::table('sociallinks')->insert(
        [
            'title' => "Tumblr",
            'icon' => '<i class="fa fa-tumblr" aria-hidden="true"></i>',
            'link' => "https://www.tumblr.com/",   
            'status' => "active",
            'order' => 8,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),     
        ]);

    }
}

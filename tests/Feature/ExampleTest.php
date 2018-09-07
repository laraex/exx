<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ExampleTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testHomePageTest()
    {
        $response = $this->get('/');
        $response->assertStatus(302);
    }
     public function testAboutPageTest()
    {
        $response = $this->get('/about');
        $response->assertStatus(200)
                ->assertViewIs("pages.about");
    }
    public function testTermPageTest()
    {
        $response = $this->get('/terms');
        $response->assertStatus(200)
                ->assertViewIs("pages.terms");
    }
    public function testPrivacyPageTest()
    {
        $response = $this->get('/privacy');
        $response->assertStatus(200)
                ->assertViewHasAll(['pages'])
                ->assertViewIs("pages.privacy");
    }

}

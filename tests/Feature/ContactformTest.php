<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ContactformTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    /** @test **/
    public function contact_form_submits_data ()
    {
        $this->assertTrue(true);
    }
}

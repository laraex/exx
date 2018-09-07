<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class NewsTest extends TestCase    {
    
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
   
   /** @test **/
    public function news_url_loads_the_correct_view()
    {
        $response = $this->get('/news');
        $response->assertStatus(200)
                ->assertViewHasAll(['news'])
                ->assertViewIs("pages.news");
    }

    /** @test **/
    public function detail_page_fetch_correct_news()
    {
        $news = \App\Models\News::find(1);

        $response = $this->get('/news/1');
        $response->assertSee($news->title);
    }
     /** @test **/
    public function only_active_news_visible()
    {
        $activenews = factory(\App\Models\News::class, 1)->create();

        $inactivenews = factory(\App\Models\News::class, 1)->create( [
            'active' => 0
            ]);

        $response = $this->get('/news');
        $response->assertStatus(200)
                ->assertViewHasAll(['news'])
                ->assertSee($activenews[0]->title)
                ->assertDontSee($inactivenews[0]->title);
    }
}
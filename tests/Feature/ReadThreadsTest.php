<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReadThreadsTest extends TestCase
{
    use RefreshDatabase;
    
    private $thread;
    
    
    public function setUp()
    {
        parent::setUp();
        
        $this->thread = create('App\Thread');
    }
    
    /**
     * A Test
     * 
     * @test
     * @return void
     */
    public function a_user_can_browse_threads()
    {   
        $response = $this->get('/threads');
        $response->assertSee($this->thread->title);
    }

    /**
     * A Test
     * 
     * @test
     * @return void
     */
    public function a_user_can_browse_a_single_thread()
    {   
        $response = $this->get($this->thread->path());
        $response->assertSee($this->thread->title);
    }

    /**
     * A Test
     * 
     * @test
     * @return void
     */
    public function user_can_see_replies_associated_with_a_thread()
    {   
        $reply = create('App\Reply', ['thread_id' => $this->thread->id]);

        $response = $this->get($this->thread->path());
        $response->assertSee($reply->body);
    }

    /**
    * @test
    *
    */
    public function a_user_can_filter_threads_based_on_channel_tags(){
        $channel = create('App\Channel');
        $threadInChannel = create('App\Thread', ['channel_id'=> $channel->id]);
        $threadNotInChannel = create('App\Thread');
        $this->withoutExceptionHandling()->get('threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }
}

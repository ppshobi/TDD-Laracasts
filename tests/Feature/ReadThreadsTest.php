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
        
        $this->thread = factory('App\Thread')->create();
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
        $response = $this->get('/threads/' . $this->thread->id);
        $response->assertSee($this->thread->title);
    }
}

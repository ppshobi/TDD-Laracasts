<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadTest extends TestCase
{
    use RefreshDatabase;

    private $thread;
    
    public function setUp()
    {
        parent::setUp();
        $this->thread = factory('App\Thread')->create();
    }
    
    /**
     * 
     * @test
     * @return void
     */
    function a_thread_has_replies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection' , $this->thread->replies);
    }

    /**
     * 
     * @test
     * @return void
     */

    function a_thread_has_owner()
    {
        $this->assertInstanceOf('App\User' , $this->thread->owner);
    }
}

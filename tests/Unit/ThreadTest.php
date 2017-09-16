<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 
     * @test
     * @return void
     */

    function a_thread_has_replies()
    {
        $thread = factory('App\Thread')->create();

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection' , $thread->replies);
    }

    /**
     * 
     * @test
     * @return void
     */

    function a_thread_has_owner()
    {
        $thread = factory('App\Thread')->create();

        $this->assertInstanceOf('App\User' , $thread->owner);
    }
}

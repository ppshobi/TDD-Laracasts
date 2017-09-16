<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParticipateInForumTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * 
     * @test
     *
     * @return void
     */

    function an_authenticated_may_participate_in_threads()
    {
        $this->be($user = factory('App\User')->create());

        $thread = factory('App\Thread')->create();

        $reply = factory('App\Reply')->create(['user_id'=> $thread->owner->id]);

        $this->post($thread->path() . '/replies', $reply->toArray());

        $this->get($thread->path())->assertSee($reply->body);
    }

    /**
     * 
     * @test
     *
     * @return void
     */

    function an_un_authenticated_can_not_participate_in_threads()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $thread = factory('App\Thread')->create();
        $reply = factory('App\Reply')->create();

        $this->post($thread->path() . '/replies', $reply->toArray());

    }
}

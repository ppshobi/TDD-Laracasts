<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParticipateInForumTest extends TestCase {

    use RefreshDatabase;

    /**
     *
     * @test
     *
     * @return void
     */
    function an_authenticated_user_may_participate_in_threads()
    {
        $this->signIn();
        $thread = create('App\Thread');
        $reply = make('App\Reply', ['user_id' => $thread->owner->id]);
        $this->post($thread->path() . '/replies', $reply->toArray());
        $this->get($thread->path())->assertSee($reply->body);
    }

    /**
    * @test
    *
    */
    public function a_reply_have_a_body(){
        $this->signIn();
        $thread = create('App\Thread');
        $reply = make('App\Reply', ['body' => null]);
        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertSessionHasErrors('body');
    }

    /**
     *
     * @test
     *
     * @return void
     */
    function an_un_authenticated_user_can_not_participate_in_threads()
    {

        $thread = create('App\Thread');
        $reply = make('App\Reply');
        $this->withExceptionHandling()
            ->post($thread->path() . '/replies', $reply->toArray())
            ->assertRedirect('/login');

    }
}

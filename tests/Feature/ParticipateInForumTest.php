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
    function an_authenticated_user_may_participate_in_threads()
    {
        $this->signIn();
        $thread = create('App\Thread');
        $reply  = make('App\Reply', ['user_id' => $thread->owner->id]);
        $this->post($thread->path() . '/replies', $reply->toArray());

        $this->assertDatabaseHas('replies', ['body' => $reply->body]);
        $this->assertEquals(1, $thread->fresh()->replies_count);
    }

    /**
     * @test
     *
     */
    public function a_reply_have_a_body()
    {
        $this->signIn();
        $thread = create('App\Thread');
        $reply  = make('App\Reply', ['body' => null]);
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
        $reply  = make('App\Reply');
        $this->withExceptionHandling()
            ->post($thread->path() . '/replies', $reply->toArray())
            ->assertRedirect('/login');

    }

    /**
     * @test
     *
     */
    public function unauthorized_users_can_not_delete_replies()
    {
        $reply = create('App\Reply');

        $this->withExceptionHandling()
            ->delete("/replies/{$reply->id}")
            ->assertRedirect('login');

        $this->signIn()
            ->delete("/replies/{$reply->id}")
            ->assertStatus(403);
    }

    /**
     * @test
     *
     */
    public function authorized_user_can_delete_replies()
    {
        $this->signIn();
        $reply = create('App\Reply', ['user_id' => auth()->id()]);

        $this->delete("/replies/{$reply->id}")->assertStatus(302);

        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
        $this->assertEquals(0, $reply->thread->fresh()->replies_count);
    }

    /**
     * @test
     *
     */
    public function authorized_users_can_update_replies()
    {
        $this->signIn();
        $reply        = create('App\Reply', ['user_id' => auth()->id()]);
        $updatedReply = 'Reply Updated';

        $this->withoutExceptionHandling()
            ->patch("/replies/{$reply->id}", ['body' => $updatedReply,]);

        $this->assertDatabaseHas('replies', [
            'id'   => $reply->id,
            'body' => $updatedReply,
        ]);
    }

    /**
     * @test
     *
     */
    public function unauthorized_users_can_not_update_replies()
    {
        $reply = create('App\Reply');

        $this->withExceptionHandling()
            ->patch("/replies/{$reply->id}")
            ->assertRedirect('login');

        $this->signIn()
            ->patch("/replies/{$reply->id}")
            ->assertStatus(403);
    }

    /**
     * @test
     *
     */
    public function replies_that_contain_spam_may_not_be_posted()
    {
        $this->signIn();
        $thread = create('App\Thread');
        $reply  = make('App\Reply', [
            'body' => 'Yahoo Customer Support'
        ]);

        $this->expectException(\Exception::class);

        $this->withoutExceptionHandling()->post($thread->path() . '/replies', $reply->toArray());
    }
}

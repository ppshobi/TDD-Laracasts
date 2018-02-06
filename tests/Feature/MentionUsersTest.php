<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MentionUsersTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     *
     */
    public function users_mentioned_in_a_reply_gets_notified()
    {
        $john = create('App\User',['name' => 'JohnDoe']);
        $jane = create('App\User',['name' => 'JaneDoe']);

        $thread = create('App\Thread');

        $this->signIn($john);

        $reply = make('App\Reply',['body' => '@JaneDoe Look here, @FrankDoe clear your tasks.']);

        $this->json('post', $thread->path() . '/replies', $reply->toArray());

        $this->assertCount(1, $jane->notifications);
    }
}

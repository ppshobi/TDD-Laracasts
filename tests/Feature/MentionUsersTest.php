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

        $this->withOutExceptionHandling()->json('post', $thread->path() . '/replies', $reply->toArray());

        $this->assertCount(1, $jane->notifications);
    }

    /**
     * @test
     *
     */
    public function it_can_fetch_all_mentioned_users_starting_with_given_characters()
    {
        create('App\User', ['name' => 'JhonDoe']);
        create('App\User', ['name' => 'JhonDoe2']);
        create('App\User', ['name' => 'JaneDoe']);

        $response = $this->json('get', '/api/users',['name' => 'jhon']);

        $this->assertCount(2, $response->json());
    }
}

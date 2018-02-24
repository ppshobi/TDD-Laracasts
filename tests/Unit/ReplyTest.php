<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReplyTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     * @test
     * @return void
     */
    function it_has_an_owner()
    {
        $reply = create('App\Reply');

        $this->assertInstanceOf('App\User', $reply->owner);
    }

    /**
     * @test
     *
     */
    public function it_knows_if_it_was_just_published()
    {
        $reply = create('App\Reply');

        $this->assertTrue($reply->wasJustPublished());

        $reply->created_at= Carbon::now()->subMonth();

        $this->assertFalse($reply->wasJustPublished());
    }

    /**
     * @test
     *
     */
    public function it_can_detect_all_mentioned_users_from_the_body()
    {
        $reply = create('App\Reply', ['body' => '@JaneDoe wants to talk to @JhonDoe']);
        $this->assertEquals(['JaneDoe', 'JhonDoe'], $reply->mentionedUsers());
    }

    /**
     * @test
     *
     */
    public function it_wraps_mentioned_usernames_within_anchor_tags()
    {
        $reply = create('App\Reply', ['body' => 'Hello @JaneDoe']);

        $this->assertEquals('Hello <a href="/profiles/JaneDoe">@JaneDoe</a>' , $reply->body);
    }
}

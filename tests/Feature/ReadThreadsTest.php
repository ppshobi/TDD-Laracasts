<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReadThreadsTest extends TestCase {

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
    public function a_user_can_filter_threads_based_on_channel_tags()
    {
        $channel = create('App\Channel');
        $threadInChannel = create('App\Thread', ['channel_id' => $channel->id]);
        $threadNotInChannel = create('App\Thread');
        $this->withoutExceptionHandling()->get('threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }

    /**
     * @test
     *
     */
    public function a_user_can_filter_threads_by_username()
    {
        $this->signIn(create('App\User', ['name' => 'Shobi']));
        $threadByShobi = create('App\Thread', ['user_id' => auth()->id()]);
        $threadByOtherGuy = create('App\Thread');
        $this->get('threads?by=Shobi')
            ->assertSee($threadByShobi->title)
            ->assertDontSee($threadByOtherGuy->title);
    }

    /**
     * @test
     *
     */
    public function a_user_can_filter_threads_by_popularity()
    {
        $threadWithTwoReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithTwoReplies->id], 2);

        $threadWithThreeReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithThreeReplies->id], 3);

        $threadWithZeroReplies = create('App\Thread');

        $response = $this->getJson('/threads?popularity=1')->json();
        $this->assertEquals([3, 2, 0], array_column($response, 'replies_count'));

    }
}

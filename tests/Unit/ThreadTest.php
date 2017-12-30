<?php

namespace Tests\Unit;

use App\Notifications\ThreadWasUpdated;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadTest extends TestCase {

    use RefreshDatabase;

    private $thread;

    public function setUp()
    {
        parent::setUp();
        $this->thread = create('App\Thread');
    }

    /**
     *
     * @test
     * @return void
     */
    function a_thread_has_replies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }

    /**
     *
     * @test
     * @return void
     */
    function a_thread_has_owner()
    {
        $this->assertInstanceOf('App\User', $this->thread->owner);
    }


    /**
     *
     * @test
     */
    function a_thread_can_add_reply()
    {
        $this->thread->addReply([
            'body' => 'Reply Body',
            'user_id' => 1
        ]);
        $this->assertCount(1, $this->thread->replies);
    }

    /**
     * @test
     *
     */
    public function a_thread_notifies_all_the_subscribers_when_a_reply_added()
    {
        Notification::fake();

        $this->signIn()->thread->subscribe()->addReply([
            'body' => 'Reply Body',
            'user_id' => 999
        ]);

        Notification::assertSentTo(auth()->user(), ThreadWasUpdated::class);

    }

    /**
     * @test
     * */
    function a_thread_belongs_to_a_channel()
    {
        $thread = create('App\Thread');
        $this->assertInstanceOf('App\Channel', $thread->channel);
    }

    /**
     * @test
     */
    public function a_thread_can_make_a_string_path()
    {
        $thread = create('App\Thread');
        $this->assertEquals("/threads/{$thread->channel->slug}/{$thread->id}", $thread->path());
    }

    /**
     * @test
     *
     */
    public function a_thread_can_be_subscribed_to()
    {
        $thread = create('App\Thread');

        $thread->subscribe($userId = 1);

        $this->assertEquals(1, $thread->subscriptions()->where('user_id', $userId)->count());

    }

    /**
     * @test
     *
     */
    public function a_thread_can_be_unsubscribed_from()
    {
        $thread = create('App\Thread');

        $thread->subscribe($userId = 1);

        $thread->unsubscribe($userId);

        $this->assertCount(0, $thread->subscriptions);
    }

    /**
     * @test
     *
     */
    public function it_knows_if_authenticated_user_is_subscribed_to_it()
    {
        $thread = create('App\Thread');

        $this->signIn();

        $this->assertFalse($thread->isSubscribedTo);

        $thread->subscribe();

        $this->assertTrue($thread->isSubscribedTo);
    }

    /**
     * @test
     *
     */
    public function a_thread_can_check_if_the_authenticated_user_has_read_all_replies()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $this->assertTrue($thread->hasUpdatesFor(auth()->user()));

        $key = sprintf("users.%s.visits.%s", auth()->id(), $thread->id);
        cache()->forever($key, Carbon::now());

        $this->assertFalse($thread->hasUpdatesFor(auth()->user()));
    }
}

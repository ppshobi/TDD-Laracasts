<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscribeToThreadsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     *
     */
    public function a_user_can_subscribe_to_threads()
    {
        $this->signIn();
        $thread = create('App\Thread');

        $this->withoutExceptionHandling()->post($thread->path() . '/subscriptions');

        $this->assertCount(1, $thread->fresh()->subscriptions);
    }

    /**
     * @test
     *
     */
    public function a_user_can_un_subscribe_from_a_thread()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $thread->subscribe();

        $this->withoutExceptionHandling()->delete($thread->path() . '/subscriptions');

        $this->assertCount(0, $thread->subscriptions);

    }
}

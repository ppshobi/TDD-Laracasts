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

        $thread->addReply([
            'user_id' => auth()->id(),
            'body'    => 'Some Test Reply',
        ]);

//        $this->assertCount(1, auth()->user()->notifications);
    }
}

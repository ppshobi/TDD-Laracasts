<?php

namespace Tests\Unit;

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
        $this->assertEquals('/threads/' . $thread->channel->slug . '/' . $thread->id, $thread->path());
    }
}

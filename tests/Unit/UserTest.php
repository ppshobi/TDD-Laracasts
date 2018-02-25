<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     *
     */
    public function a_user_can_fetch_their_most_recent_reply()
    {
        $user = create('App\User');
        $reply = create('App\Reply',['user_id' => $user->id]);

        $this->assertEquals($user->lastReply->id, $reply->id);
    }

    /**
     * @test
     *
     */
    public function a_user_can_determine_the_avatar_path()
    {
        $user = create('App\User');

        $this->assertEquals(asset('images/user.png'), $user->avatar());

        $user = create('App\User', ['avatar_path' => 'avatars/me.jpg']);

        $this->assertEquals($user->avatar(), asset('storage/' . 'avatars/me.jpg'));
    }
}

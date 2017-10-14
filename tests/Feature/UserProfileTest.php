<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserProfileTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     *
     */
    public function a_user_has_a_profile ()
    {
        $user = create('App\User');

        $this->withoutExceptionHandling()
            ->get('/profiles/' . $user->name)
            ->assertSee($user->name);
    }

    /**
     * @test
     *
     */
    public function a_user_profile_contains_all_the_threads_of_the_user ()
    {
        $this->signIn();
        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $this->get('/profiles/' . auth()->user()->name)
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}

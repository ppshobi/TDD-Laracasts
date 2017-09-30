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

}

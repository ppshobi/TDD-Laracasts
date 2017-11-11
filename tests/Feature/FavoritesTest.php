<?php

namespace Tests\Feature;

use App\Favorite;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FavoritesTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     *
     */
    public function guests_can_not_favorite_anything()
    {
        $this->post('/replies/1/favorites')
            ->assertRedirect('/login');
    }

    /**
     * @test
     *
     */
    public function an_authenticated_user_can_favorite_any_reply()
    {
        $this->signIn();
        $reply = create('App\Reply');
        $this->withoutExceptionHandling()->post('/replies/' . $reply->id . '/favorites');
        $this->assertCount(1, $reply->favorites);
    }

    /**
     * @test
     *
     */
    public function an_authenticated_user_can_unfavorite_any_reply()
    {
        $this->signIn();
        $reply = create('App\Reply');

        $reply->favorite();

        $this->withoutExceptionHandling()->delete('/replies/' . $reply->id . '/favorites');
        $this->assertCount(0, $reply->favorites);
    }

    /**
     * @test
     *
     */
    public function an_authenticated_user_can_favourite_a_reply_once ()
    {
        $this->signIn();
        $reply = create('App\Reply');
        try {
            $this->withoutExceptionHandling()->post('/replies/' . $reply->id . '/favorites');
            $this->withoutExceptionHandling()->post('/replies/' . $reply->id . '/favorites');
        } catch (\Exception $e) {
            $this->fail("User can't favorite a reply more than once");
        }

        $this->assertCount(1, $reply->favorites);
    }
}

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
}

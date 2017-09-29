<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FavoritesTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     *
     */
    public function an_authenticated_user_can_favorite_any_reply()
    {
        $reply = create('App\Reply');
        $this->withoutExceptionHandling()
            ->post('/replies/' . $reply->id . '/favorites');
        $this->assertCount(1, $reply->favorites);
    }
}

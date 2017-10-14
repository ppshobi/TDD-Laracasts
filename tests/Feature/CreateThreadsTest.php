<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class CreateThreadsTest
 * @package Tests\Feature
 */
class CreateThreadsTest extends TestCase {

    use RefreshDatabase;

    /**
     * @test
     * @return void
     */
    public function an_authenticated_user_can_create_threads()
    {
        $this->signIn();
        $thread = make('App\Thread');
        $response = $this->post('/threads', $thread->toArray());
        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /**
     * @test
     * @return void
     */
    public function an_unauthenticated_user_can_not_create_threads()
    {
        $this->withExceptionHandling();
        $this->post('/threads')
            ->assertRedirect('/login');
        $this->get('/threads/create')
            ->assertRedirect('/login');
    }

    /**
     * @test
     * */
    public function a_thread_require_a_title()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /**
    * @test
    *
    */
    public function a_thread_require_a_body(){
        $this->publishThread(['body'=>null])
            ->assertSessionHasErrors('body');
    }

    /**
    * @test
    *
    */
    public function a_thread_require_a_valid_channel(){
        factory('App\Channel', 2)->create();

        $this->publishThread(['channel_id'=>null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id'=>999])
            ->assertSessionHasErrors('channel_id');
    }

    /**
     * @param array $overRides
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function publishThread($overRides = [])
    {
        $this->signIn();
        $thread = make('App\Thread', $overRides);
        return $this->post('/threads', $thread->toArray());
    }

    /**
     * @test
     *
     */
    public function authorized_user_can_delete_a_thread ()
    {
        $this->signIn();
        $thread = create('App\Thread', ['user_id' => auth()->id()]);
        $reply = create('App\Reply', ['thread_id' => $thread->id]);

        $response = $this->withoutExceptionHandling()
            ->json('DELETE', $thread->path());

        $response->assertStatus(204);
        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
        $this->assertDatabaseMissing('activities', [
            'subject_id' => $thread->id,
            'subject_type' => get_class($thread),
        ]);
        $this->assertDatabaseMissing('activities', [
            'subject_id' => $reply->id,
            'subject_type' => get_class($reply),
        ]);
    }

    /**
     * @test
     *
     */
    public function unauthorized_user_can_not_delete_a_thread ()
    {
        $thread = create('App\Thread');

        $this->delete($thread->path())
            ->assertRedirect('/login');

        $this->signIn();

        $this->delete($thread->path())
            ->assertStatus(403);
    }
}

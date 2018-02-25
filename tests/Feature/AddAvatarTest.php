<?php

namespace Tests\Feature;

use Storage;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class AddAvatarTest
 * @package Tests\Feature
 */
class AddAvatarTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     *
     */
    public function only_members_are_allowed_to_set_an_avatar()
    {
        $this->json('post', '/api/users/1/avatar')
             ->assertStatus(401);
    }

    /**
     * @test
     *
     */
    public function a_valid_avatar_must_be_provided()
    {
        $this->signIn();

        $this->json('post', '/api/users/' . auth()->id() . '/avatar', ['avatar' => 'not-an-image'])
             ->assertStatus(422);
    }

    /**
     * @test
     *
     */
    public function a_member_can_add_avatar_to_their_profile()
    {
        $this->signIn();

        Storage::fake('public');

        $this->json('post', '/api/users/' . auth()->id() . '/avatar', [
            'avatar' => $file = UploadedFile::fake()->image('avatar.jpg'),
        ]);

        Storage::disk('public')->assertExists("avatars/" . $file->hashName());
    }
}

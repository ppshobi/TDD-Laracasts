<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class UserPolicy
 * @package App\Policies
 */
class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the profile
     *
     * @param  \App\User $user
     * @param  \App\User $signedInUser
     * @return bool
     */
    public function update(User $user, User $signedInUser)
    {
        return $user->id === $signedInUser->id;
    }
}

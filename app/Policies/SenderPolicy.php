<?php

namespace App\Policies;

use App\Models\Sender;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SenderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User|null $user
     * @return mixed
     */
    public function viewAny(?User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isModerator();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Sender $sender
     * @return mixed
     */
    public function update(User $user, Sender $sender)
    {
        return $user->isModerator();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Sender $sender
     * @return mixed
     */
    public function delete(User $user, Sender $sender)
    {
        return $user->isModerator();
    }
}

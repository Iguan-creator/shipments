<?php

namespace App\Policies;

use App\Models\Receiver;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReceiverPolicy
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
     * @param Receiver $receiver
     * @return mixed
     */
    public function update(User $user, Receiver $receiver)
    {
        return $user->isModerator();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Receiver $receiver
     * @return mixed
     */
    public function delete(User $user, Receiver $receiver)
    {
        return $user->isModerator();
    }
}

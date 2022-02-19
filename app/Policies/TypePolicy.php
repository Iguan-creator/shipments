<?php

namespace App\Policies;

use App\Models\Type;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TypePolicy
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
     * Determine whether the user can view dependencies.
     *
     * @param User $user
     * @param Type $type
     * @return bool
     */
    public function viewDependencies(User $user, Type $type)
    {
        return $user->isModerator();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User|null $user
     * @param Type $type
     * @return mixed
     */
    public function view(?User $user, Type $type)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Type $type
     * @return mixed
     */
    public function update(User $user, Type $type)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model dependencies.
     *
     * @param User $user
     * @param Type $type
     * @return bool
     */
    public function updateDependencies(User $user, Type $type)
    {
        return $user->isModerator();
    }
}

<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientPolicy
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
     * Determine whether the user can view the model.
     *
     * @param User|null $user
     * @param Client $client
     * @return mixed
     */
    public function view(?User $user, Client $client)
    {
        return true;
    }

    /**
     * Determine whether the user can view this model dependencies
     *
     * @param User $user
     * @param Client $client
     * @return bool
     */
    public function viewDependencies(User $user, Client $client)
    {
        return $user->isModerator();
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
     * @param Client $client
     * @return mixed
     */
    public function update(User $user, Client $client)
    {
        return $user->isModerator();
    }

    /**
     * Determine whether the user can update this model dependencies
     *
     * @param User $user
     * @param Client $client
     * @return bool
     */
    public function updateDependencies(User $user, Client $client)
    {
        return $user->isModerator();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Client $client
     * @return mixed
     */
    public function delete(User $user, Client $client)
    {
        return $user->isModerator();
    }
}

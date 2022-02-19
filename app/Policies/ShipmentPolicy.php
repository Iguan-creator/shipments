<?php

namespace App\Policies;

use App\Models\Shipment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShipmentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param User|null $user
     * @param Shipment $shipment
     * @return mixed
     */
    public function view(?User $user, Shipment $shipment)
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
        return $user->role <= 3;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Shipment $shipment
     * @return mixed
     */
    public function update(User $user, Shipment $shipment)
    {
        return $shipment->user_id === $user->id || $user->isModerator();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Shipment $shipment
     * @return mixed
     */
    public function delete(User $user, Shipment $shipment)
    {
        return $shipment->user_id === $user->id || $user->isModerator();
    }
}

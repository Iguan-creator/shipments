<?php


namespace App\Models\Helpers;

use App\Models\Client;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;

/**
 * Trait AssociatedWithClient
 * @package App\Models\Helpers
 *
 * @mixin Eloquent
 *
 * @property Collection $clients
 */
trait AssociatedWithClient
{
    /**
     * Parent relationship
     *
     * @return mixed
     */
    public function clients()
    {
        return $this->belongsToMany(Client::class);
    }
}

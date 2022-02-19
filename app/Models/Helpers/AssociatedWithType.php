<?php


namespace App\Models\Helpers;

use App\Models\Type;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;

/**
 * Trait AssociatedWithType
 * @package App\Models\Helpers
 *
 * @mixin Eloquent
 *
 * @property Collection $types
 */
trait AssociatedWithType
{
    /**
     * Parent relationship
     *
     * @return mixed
     */
    public function types()
    {
        return $this->belongsToMany(Type::class);
    }
}

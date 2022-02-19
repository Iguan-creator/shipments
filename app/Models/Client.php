<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Client
 * @package App\Models
 *
 * @mixin Eloquent
 *
 * @property int $id
 * @property string $name
 * @property Collection $sellers
 * @property Collection $loadPlaces
 * @property Collection $deliveryPlaces
 * @property Collection $receivers
 * @property Collection $senders
 */
class Client extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'frequency',
        'frequency_1',
        'frequency_2',
        'frequency_3',
        'frequency_4',
        'frequency_5',
        'frequency_6',
        'frequency_7',
        'frequency_8',
        'frequency_9',
        'frequency_10',
        'frequency_11',
        'created_at',
        'updated_at'
    ];

    /**
     * Sellers dependencies
     *
     * @return BelongsToMany
     */
    public function sellers()
    {
        return $this->belongsToMany(Seller::class);
    }

    /**
     * Load places dependencies
     *
     * @return BelongsToMany
     */
    public function loadPlaces()
    {
        return $this->belongsToMany(LoadPlace::class);
    }

    /**
     * Delivery places dependencies
     *
     * @return BelongsToMany
     */
    public function deliveryPlaces()
    {
        return $this->belongsToMany(DeliveryPlace::class);
    }

    /**
     * Receivers dependencies
     *
     * @return BelongsToMany
     */
    public function receivers()
    {
        return $this->belongsToMany(Receiver::class);
    }

    /**
     * Senders dependencies
     *
     * @return BelongsToMany
     */
    public function senders()
    {
        return $this->belongsToMany(Sender::class);
    }
}

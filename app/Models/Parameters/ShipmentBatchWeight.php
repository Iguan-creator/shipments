<?php

namespace App\Models\Parameters;

use App\Models\Helpers\TouchesParentShipment;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ShipmentBatchWeight
 * @package App\Models\Parameters
 *
 * @property int $id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property int $value
 */
class ShipmentBatchWeight extends Model
{
    use HasFactory, TouchesParentShipment;

    protected $fillable = ['value'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'id',
        'shipment_id',
    ];

    /**
     * All of the relationships to be touched.
     *
     * @var array
     */
    protected $touches = ['shipment'];
}

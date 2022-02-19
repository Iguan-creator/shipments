<?php

namespace App\Models\Parameters;

use App\Models\Helpers\TouchesParentShipment;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ShipmentPositionNumber
 * @package App\Models\Parameters
 *
 * @mixin Eloquent
 *
 * @property int $id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property integer $value
 */
class ShipmentPositionNumber extends Model
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

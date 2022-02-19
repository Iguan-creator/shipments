<?php

namespace App\Models\Parameters;

use App\HelperClasses\ChangeFrequency;
use App\Models\Helpers\TouchesParentShipment;
use App\Models\Station;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ShipmentStation
 * @package App\Models\Parameters
 *
 * @property int $id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Station $value
 */
class ShipmentStation extends Model
{
    use HasFactory, RelatedToAnotherModel, TouchesParentShipment, ChangeFrequency;

    protected $fillable = ['station_id'];

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
        'station_id'
    ];

    /**
     * All of the relationships to be touched.
     *
     * @var array
     */
    protected $touches = ['shipment'];

    protected $with = ['value'];
}

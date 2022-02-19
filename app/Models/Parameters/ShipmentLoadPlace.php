<?php

namespace App\Models\Parameters;

use App\HelperClasses\ChangeFrequency;
use App\Models\Helpers\TouchesParentShipment;
use App\Models\LoadPlace;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ShipmentLoadPlace
 * @package App\Models\Parameters
 *
 * @property int $id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property LoadPlace $value
 */
class ShipmentLoadPlace extends Model
{
    use HasFactory, RelatedToAnotherModel, TouchesParentShipment, ChangeFrequency;

    protected $fillable = ['load_place_id'];

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
        'load_place_id'
    ];

    /**
     * All of the relationships to be touched.
     *
     * @var array
     */
    protected $touches = ['shipment'];

    protected $with = ['value'];
}

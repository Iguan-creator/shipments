<?php

namespace App\Models\Parameters;

use App\HelperClasses\ChangeFrequency;
use App\Models\Helpers\TouchesParentShipment;
use App\Models\Sender;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ShipmentSender
 * @package App\Models\Parameters
 *
 * @property int $id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Sender $value
 */
class ShipmentSender extends Model
{
    use HasFactory, RelatedToAnotherModel, TouchesParentShipment, ChangeFrequency;

    protected $fillable = ['sender_id'];

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
        'sender_id'
    ];

    /**
     * All of the relationships to be touched.
     *
     * @var array
     */
    protected $touches = ['shipment'];

    protected $with = ['value'];
}

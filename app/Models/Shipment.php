<?php

namespace App\Models;

use App\Models\Helpers\ShipmentParameterRelationships;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

/**
 * Class Shipment
 * @package App\Models
 *
 * @mixin Eloquent
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $type_id
 * @property Type $type
 * @property boolean $filled
 * @property boolean $documents_sent
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $finished
 */
class Shipment extends Model
{
    use HasFactory, ShipmentParameterRelationships;

    /**
     * Shipments filter by date field.
     */
    const DATE_FIELD = 'sendPlannedDate';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Filter a collection of the results by date
     *
     * @param string $from
     * @param string $to
     * @return Builder
     */
    public static function filterByDates(string $from, string $to)
    {
        return static::query()->whereBetween('created_at', [$from, $to]);
    }

    /**
     * Current shipment type instance
     *
     * @return BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {

        self::created(function ($shipment) {
            $shipment->load('type');
        });
    }

    /**
     * Get the model's relationships in array form.
     *
     * It is redetermined in order to get rid of relation column 'value'
     *
     * For this application we use relation 'value' column as main value
     * of the parameter
     *
     * @return array
     */
    public function relationsToArray()
    {
        $attributes = [];

        foreach ($this->getArrayableRelations() as $key => $value) {
            $relation = $value ? $value->toArray() : $value;

            if ($value instanceof Collection) {
                array_walk($relation, function (&$value) {
                    if (isset($value['value'])) {
                        $value = $value['value'];
                    }
                });
            }

            if (static::$snakeAttributes) {
                $key = Str::snake($key);
            }

            if (isset($relation) || is_null($value)) {
                if (is_array($relation)) {
                    $attributes[$key] = array_key_exists('value', $relation) ? $relation['value'] : $relation;
                } else {
                    $attributes[$key] = $relation;
                }
            }

            unset($relation);
        }

        return $attributes;
    }

    /**
     * Current shipment user
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Finish current shipment
     */
    public function finish()
    {
        $this->finished = true;
        $this->save();
    }
}

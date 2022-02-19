<?php


namespace App\Models\Helpers;


use App\Models\Shipment;

/**
 * Trait TouchesParentShipment
 * @package App\Models\Helpers
 *
 * @property $shipment
 */
trait TouchesParentShipment
{
    /**
     * Parent relationship
     *
     * @return mixed
     */
    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }
}

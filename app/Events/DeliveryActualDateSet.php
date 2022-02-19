<?php

namespace App\Events;

use App\Models\Parameters\ShipmentDeliveryActualDate;
use Carbon\Carbon;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DeliveryActualDateSet
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Actual date
     *
     * @var Carbon
     */
    public $actualDateValue;

    /**
     * Position number
     *
     * @var mixed
     */
    public $positionNumber;

    /**
     * Create a new event instance.
     *
     * @param ShipmentDeliveryActualDate $shipmentDeliveryActualDate
     */
    public function __construct(ShipmentDeliveryActualDate $shipmentDeliveryActualDate)
    {
        $this->actualDateValue = $shipmentDeliveryActualDate->value ?
            $shipmentDeliveryActualDate->value->toDateString() :
            null;
        $this->positionNumber = $shipmentDeliveryActualDate->shipment->positionNumber->value;
    }
}

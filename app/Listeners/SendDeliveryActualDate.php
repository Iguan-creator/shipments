<?php

namespace App\Listeners;

use App\Events\DeliveryActualDateSet;
use Illuminate\Support\Facades\Http;

class SendDeliveryActualDate
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param DeliveryActualDateSet $event
     * @return void
     */
    public function handle(DeliveryActualDateSet $event)
    {
        if (!$event->actualDateValue) {
            return;
        }
        //TODO: set request for updating
        /*Http::asForm()->post(env('ONE_S_SERVER_ADDRESS') . '/save', [
            'position_number' => $event->positionNumber,
            'date' => $event->actualDateValue
        ]);*/

    }
}

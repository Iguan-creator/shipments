<?php

use App\Models\Parameters\ShipmentArrivalPortDate;
use App\Models\Shipment;
use Illuminate\Database\Migrations\Migration;

class CheckArrivalPortDate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $withoutArrivalPortNumber = Shipment::doesntHave('arrivalPortDate')
            ->where('type_id', 2)
            ->orWhere('type_id', 3)
            ->get();

        foreach ($withoutArrivalPortNumber as $record) {
            $newRecord = new ShipmentArrivalPortDate;

            $newRecord->shipment_id = $record->id;
            $newRecord->value = null;

            $newRecord->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        ShipmentArrivalPortDate::query()->delete();
    }
}

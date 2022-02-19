<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Shipment;
use App\Models\Parameters\ShipmentBookingNumber;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CheckBookingNumbers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $withoutBookingNumbers = Shipment::doesntHave('bookingNumber')
            ->where('type_id', 7)
            ->get();

        foreach ($withoutBookingNumbers as $record) {
            ShipmentBookingNumber::insert(['shipment_id' => $record->id]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

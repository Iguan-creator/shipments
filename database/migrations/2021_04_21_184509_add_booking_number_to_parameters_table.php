<?php

use App\Models\Parameter;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBookingNumberToParametersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Parameter::firstOrCreate(
                ['table' => 'booking_number'],
                [
                    'plural_name' => 'Номер букинга',
                    'singular_name' => 'Номер букинга',
                    'short' => 'Ном. бук.'
                ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
            $bookingNumber = Parameter::where('table', 'booking_number');

            if (isset($bookingNumber)) {
                $bookingNumber->delete();
            }
    }
}

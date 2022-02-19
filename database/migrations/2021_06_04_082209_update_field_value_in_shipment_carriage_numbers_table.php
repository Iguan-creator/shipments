<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFieldValueInShipmentCarriageNumbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shipment_carriage_numbers', function (Blueprint $table) {
            $table->string('value', 10)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shipment_carriage_numbers', function (Blueprint $table) {
            $table->string('value', 10)->nullable(false)->change();
        });
    }
}

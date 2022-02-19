<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelation34ParameterAnd7Type extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $type_number = DB::table('types')
            ->where('name', 'ЖД-Сборка')
            ->first();

        $booking_number = DB::table('parameters')
            ->where('table', 'booking_number')
            ->first();

        if ($type_number && $booking_number) {
            DB::table('parameter_type')->insertOrIgnore([
                'parameter_id' => $booking_number->id,
                'type_id' => $type_number->id
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $type_number = DB::table('types')
            ->where('name', 'ЖД-Сборка')
            ->first();

        $booking_number = DB::table('parameters')
            ->where('table', 'booking_number')
            ->first();

        if ($type_number && $booking_number) {
            DB::table('parameter_type')
                ->where('parameter_id', $booking_number->id)
                ->where('type_id', $type_number->id)
                ->delete();
        }
    }
}

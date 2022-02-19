<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ParameterType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parameter_type', function (Blueprint $table) {
            $table->foreignId('parameter_id')->constrained()->onDelete('cascade');
            $table->foreignId('type_id')->constrained()->onDelete('cascade');
        });

        // Insert initial dependencies
        foreach (config('ini_data.parameter_type') as $type_id => $parameter_ids) {
            foreach ($parameter_ids as $parameter_id) {
                DB::table('parameter_type')->insert([
                    'parameter_id' => $parameter_id,
                    'type_id' => $type_id,
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parameter_type');
    }
}

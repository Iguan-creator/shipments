<?php

use App\Models\Parameter;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParametersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parameters', function (Blueprint $table) {
            $table->id();
            $table->string('table', 50);
            $table->string('plural_name', 50);
            $table->string('singular_name', 50);
            $table->string('short', 50);
            $table->boolean('required')->default(false);
            $table->timestamps();
        });

        foreach (config('ini_data.parameters') as $values) {
            Parameter::create($values);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parameters');
    }
}

<?php

use App\Models\Parameter;
use Illuminate\Database\Migrations\Migration;

class ContainerIsNotRequired extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $parameter = Parameter::where('table', 'container')->first();

        if ($parameter) {
            $parameter->required = false;
            $parameter->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $parameter = Parameter::where('table', 'container')->first();

        if ($parameter) {
            $parameter->required = true;
            $parameter->save();
        }
    }
}

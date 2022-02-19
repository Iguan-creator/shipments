<?php

use App\Models\Parameter;
use Illuminate\Database\Migrations\Migration;

class PostionNumberFirst extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $parameter = Parameter::find(11);
        $parameter->order = 0;
        $parameter->save();
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

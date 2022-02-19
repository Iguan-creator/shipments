<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Config;
use App\Models\Parameter;

class OrderToParametersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('parameters', function (Blueprint $table) {
            $table->integer('order')->default(null)->after('id');
        });

        $this->loadOrderValues();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('parameters', function (Blueprint $table) {
            $table->dropColumn('order');
        });
    }

    /**
     * Метод сопоставляет параметры значениям order из /config/ini_order_parameters.php
     */
    private function loadOrderValues()
    {
        $parameters = Parameter::all();
        $cfg = Config::get('ini_order_parameters');

        foreach ($parameters->all() as $parameter) {
            $id = $parameter['id'];
            $order = $cfg['parameters'][$parameter['id']]['order'];

            $modRec = Parameter::findOrNew($id);
            $modRec->order = $order;
            $modRec->save();
        }
    }
}

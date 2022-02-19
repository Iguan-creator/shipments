<?php

use App\Models\Parameter;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddArrivalPortDateToParametersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $cfg_data = Config::get('ini_data.parameters');
        $cfg_order = Config::get('ini_order_parameters');

        foreach ($cfg_data as $key => $record) {
            if ($record['table'] == 'arrival_port_date') {
                $id = $key;
            }
        }

        $order = $cfg_order['parameters'][$id]['order'];

        //Заполнение таблицы parameters
        Parameter::firstOrCreate(
            ['table' => 'arrival_port_date'],
            [
                'id' => $id,
                'plural_name' => 'Дата Порт прибытия ПЛАН',
                'singular_name' => 'Дата Порт прибытия ПЛАН',
                'short' => 'Дата Порт приб. (план).',
                'order' => $order,
            ]);

        //Заполнение таблицы parameters_type
        foreach (config('ini_data.parameter_type') as $type_id => $parameter_ids) {
            if (array_search($id, $parameter_ids)) {
                DB::table('parameter_type')->insert([
                    'parameter_id' => $id,
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
        //Удаление записей таблицы Parameter
        $arrival_port_date = Parameter::where('table', 'arrival_port_date');

        if (isset($arrival_port_date)) {
            $arrival_port_date->delete();
        }

        //Удаление записей таблицы parameter_type
        $cfg_data = Config::get('ini_data.parameters');

        foreach ($cfg_data as $key => $record) {
            if ($record['table'] == 'arrival_port_date') {
                $id = $key;
            }
        }

        DB::table('parameter_type')->where(
            'parameter_id', $id)->delete();

    }
}

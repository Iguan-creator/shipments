<?php

use App\Models\Parameter;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDataInParametersTable extends Migration
{
    /**
     * Массив для переименования отношений в таблице parameters с единственного на множественное число
     *
     * @var string[]
     */
    private $changeNames = [
        'sender' => 'senders',
        'receiver' => 'receivers',
        'load_place' => 'load_places',
        'delivery_place' => 'delivery_places'
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('parameters', function (Blueprint $table) {

            foreach ($this->changeNames as $single => $plural) {

                $record = Parameter::where('table', $single)->first();

                if ($record) {
                    $record->table = $plural;
                    $record->save();
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('parameters', function (Blueprint $table) {

            foreach ($this->changeNames as $single => $plural) {
                $record = Parameter::where('table', $plural)->first();
                if ($record) {
                    $record->table = $single;
                    $record->save();
                }
            }
        });
    }
}

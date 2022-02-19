<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveFrequencyColumnFromListsTable extends Migration
{
    private $typesId;

    private $lists;

    /**
     * RemoveFrequencyColumnFromListsTable constructor.
     */
    public function __construct()
    {
        //Инициализация приватных значений для использовании при создании или откате миграции
        $this->typesId = array_keys(config('ini_data.types'));

        $this->lists = config('ini_data.lists');

        foreach ($this->lists as &$item) {
            $item = $item['link'];
        }
        unset($item);
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->lists as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropColumn('frequency');
                foreach ($this->typesId as $typeId) {
                    $recordName = 'frequency_' . $typeId;
                    $table->unsignedBigInteger($recordName)->default(0);
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->lists as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->unsignedBigInteger('frequency')->default(0);
                foreach ($this->typesId as $typeId) {
                    $recordName = 'frequency_' . $typeId;
                    $table->dropColumn($recordName);
                }
            });
        }
    }
}

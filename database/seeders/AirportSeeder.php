<?php

namespace Database\Seeders;

use App\Models\Airport;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AirportSeeder extends Seeder
{
    public $quantity = 40;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Airport::factory($this->quantity)->create();

        foreach (config('ini_data.types') as $type_id => $type) {
            for ($i = 1; $i <= $this->quantity; $i++) {
                $prob = rand(1, 10);
                if ($prob > 5) {
                    DB::table('airport_type')->insert([
                        'airport_id' => $i,
                        'type_id' => $type_id,
                    ]);
                }
            }
        }
    }
}

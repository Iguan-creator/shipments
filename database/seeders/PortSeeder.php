<?php

namespace Database\Seeders;

use App\Models\Port;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PortSeeder extends Seeder
{
    public $quantity = 40;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Port::factory($this->quantity)->create();

        foreach (config('ini_data.types') as $type_id => $type) {
            for ($i = 1; $i <= $this->quantity; $i++) {
                $prob = rand(1, 10);
                if ($prob > 5) {
                    DB::table('port_type')->insert([
                        'port_id' => $i,
                        'type_id' => $type_id,
                    ]);
                }
            }
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Container;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContainerSeeder extends Seeder
{
    public $quantity = 10;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Container::factory($this->quantity)->create();

        foreach (config('ini_data.types') as $type_id => $type) {
            for ($i = 1; $i <= $this->quantity; $i++) {
                $prob = rand(1, 10);
                if ($prob > 5) {
                    DB::table('container_type')->insert([
                        'container_id' => $i,
                        'type_id' => $type_id,
                    ]);
                }
            }
        }
    }
}

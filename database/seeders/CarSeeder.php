<?php

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cars = [
            'Соболь',
            'Газель',
            'Бычок',
            '5-тонник',
            '10-тонник',
            'Фура',
            'Фура-120',
        ];

        foreach ($cars as $name) {
            Car::factory()->create(['name' => $name]);
        }

        foreach (config('ini_data.types') as $type_id => $type) {
            for ($i = 1; $i <= count($cars); $i++) {
                $prob = rand(1, 10);
                if ($prob > 5) {
                    DB::table('car_type')->insert([
                        'car_id' => $i,
                        'type_id' => $type_id,
                    ]);
                }
            }
        }
    }
}

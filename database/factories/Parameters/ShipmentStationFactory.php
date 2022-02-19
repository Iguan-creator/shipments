<?php

namespace Database\Factories\Parameters;

use App\Models\Parameters\ShipmentStation;
use App\Models\Station;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShipmentStationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ShipmentStation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $stations = Station::all(['id']);
        return [
            'station_id' => $stations->random()->id,
        ];
    }
}

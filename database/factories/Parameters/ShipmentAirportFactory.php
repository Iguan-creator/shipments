<?php

namespace Database\Factories\Parameters;

use App\Models\Airport;
use App\Models\Parameters\ShipmentAirport;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShipmentAirportFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ShipmentAirport::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $airports = Airport::all(['id']);
        return [
            'airport_id' => $airports->random()->id,
        ];
    }
}

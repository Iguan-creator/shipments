<?php

namespace Database\Factories\Parameters;

use App\Models\LoadPlace;
use App\Models\Parameters\ShipmentLoadPlace;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShipmentLoadPlaceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ShipmentLoadPlace::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $load_places = LoadPlace::all(['id']);
        return [
            'load_place_id' => $load_places->random()->id,
        ];
    }
}

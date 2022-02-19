<?php

namespace Database\Factories\Parameters;

use App\Models\DeliveryPlace;
use App\Models\Parameters\ShipmentDeliveryPlace;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ShipmentDeliveryPlaceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ShipmentDeliveryPlace::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $delivery_places = DeliveryPlace::all(['id']);
        return [
            'delivery_place_id' => $delivery_places->random()->id,
        ];
    }
}

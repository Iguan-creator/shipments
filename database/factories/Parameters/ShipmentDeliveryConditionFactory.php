<?php

namespace Database\Factories\Parameters;

use App\Models\DeliveryCondition;
use App\Models\Parameters\ShipmentDeliveryCondition;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ShipmentDeliveryConditionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ShipmentDeliveryCondition::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $delivery_conditions = DeliveryCondition::all(['id']);
        return [
            'delivery_condition_id' => $delivery_conditions->random()->id,
        ];
    }
}

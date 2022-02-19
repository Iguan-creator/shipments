<?php

namespace Database\Factories\Parameters;

use App\Models\Parameters\ShipmentSendActualDate;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ShipmentSendActualDateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ShipmentSendActualDate::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'value' => '2020-10-' . rand(1, 29),
        ];
    }
}

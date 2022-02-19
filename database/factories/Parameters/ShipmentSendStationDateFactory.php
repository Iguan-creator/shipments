<?php

namespace Database\Factories\Parameters;

use App\Models\Parameters\ShipmentSendStationDate;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ShipmentSendStationDateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ShipmentSendStationDate::class;

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

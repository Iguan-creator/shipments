<?php

namespace Database\Factories\Parameters;

use App\Models\Car;
use App\Models\Parameters\ShipmentCar;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ShipmentCarFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ShipmentCar::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $cars = Car::all(['id']);
        return [
            'car_id' => $cars->random()->id,
        ];
    }
}

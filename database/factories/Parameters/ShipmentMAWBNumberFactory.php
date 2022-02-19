<?php

namespace Database\Factories\Parameters;

use App\Models\Parameters\ShipmentMAWBNumber;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ShipmentMAWBNumberFactory extends Factory
{
    use RandomLettersExtension;

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ShipmentMAWBNumber::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'value' => $this->letters(3) . $this->faker->randomNumber(8),
        ];
    }
}

<?php

namespace Database\Factories\Parameters;

use App\Models\Parameters\ShipmentContainerNumber;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ShipmentContainerNumberFactory extends Factory
{
    use RandomLettersExtension;

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ShipmentContainerNumber::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'value' => $this->letters(4) . $this->faker->randomNumber(7),
        ];
    }
}

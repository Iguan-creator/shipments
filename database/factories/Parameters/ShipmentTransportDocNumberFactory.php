<?php

namespace Database\Factories\Parameters;

use App\Models\Parameters\ShipmentTransportDocNumber;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ShipmentTransportDocNumberFactory extends Factory
{
    use RandomLettersExtension;

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ShipmentTransportDocNumber::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'value' => $this->letters(2) . $this->faker->randomNumber(6),
        ];
    }
}

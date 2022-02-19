<?php

namespace Database\Factories;

use App\Models\DeliveryCondition;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DeliveryConditionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DeliveryCondition::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => Str::upper($this->faker->randomLetter . $this->faker->randomLetter . $this->faker->randomLetter),
        ];
    }
}

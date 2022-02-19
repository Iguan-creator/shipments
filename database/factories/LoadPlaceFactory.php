<?php

namespace Database\Factories;

use App\Models\LoadPlace;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class LoadPlaceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LoadPlace::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->city,
        ];
    }
}

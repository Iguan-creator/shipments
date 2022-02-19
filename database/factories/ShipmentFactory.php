<?php

namespace Database\Factories;

use App\Models\Shipment;
use App\Models\Type;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShipmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Shipment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $types = Type::all(['id']);
        $users = User::all(['id']);

        return [
            'type_id' => $types->random()->id,
            'user_id' => $users->random()->id,
            'filled' => rand(1,10) > 8 ? 0 : 1,
        ];
    }
}

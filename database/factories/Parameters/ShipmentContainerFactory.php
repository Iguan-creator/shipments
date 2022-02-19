<?php

namespace Database\Factories\Parameters;

use App\Models\Container;
use App\Models\Parameters\ShipmentContainer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ShipmentContainerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ShipmentContainer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $containers = Container::all(['id']);
        return [
            'container_id' => $containers->random()->id,
        ];
    }
}

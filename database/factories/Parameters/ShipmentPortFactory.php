<?php

namespace Database\Factories\Parameters;

use App\Models\Parameters\ShipmentPort;
use App\Models\Port;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ShipmentPortFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ShipmentPort::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $ports = Port::all(['id']);
        return [
            'port_id' => $ports->random()->id,
        ];
    }
}

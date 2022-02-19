<?php

namespace Database\Factories\Parameters;

use App\Models\Parameters\ShipmentReceiver;
use App\Models\Receiver;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShipmentReceiverFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ShipmentReceiver::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $receivers = Receiver::all(['id']);
        return [
            'receiver_id' => $receivers->random()->id,
        ];
    }
}

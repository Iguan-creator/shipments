<?php

namespace Database\Factories\Parameters;

use App\Models\Parameters\ShipmentSender;
use App\Models\Sender;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShipmentSenderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ShipmentSender::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $senders = Sender::all(['id']);
        return [
            'sender_id' => $senders->random()->id,
        ];
    }
}

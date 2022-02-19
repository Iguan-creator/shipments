<?php

namespace Database\Factories\Parameters;

use App\Models\Client;
use App\Models\Parameters\ShipmentClient;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ShipmentClientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ShipmentClient::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $clients = Client::all(['id']);
        return [
            'client_id' => $clients->random()->id,
        ];
    }
}

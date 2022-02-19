<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\DeliveryPlace;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeliveryPlaceSeeder extends Seeder
{
    public $quantity = 40;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DeliveryPlace::factory($this->quantity)->create();

        foreach (Client::all() as $client) {
            for ($i = 1; $i <= $this->quantity; $i++) {
                $prob = rand(1, 10);
                if ($prob > 5) {
                    DB::table('client_delivery_place')->insert([
                        'client_id' => $client->id,
                        'delivery_place_id' => $i,
                    ]);
                }
            }
        }
    }
}

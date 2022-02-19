<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\DeliveryCondition;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create();
        Client::factory(20)->create();
        DeliveryCondition::factory(10)->create();

        $this->call([
            CarSeeder::class,
            SellerSeeder::class,
            ContractorSeeder::class,
            ContainerSeeder::class,
            AirportSeeder::class,
            PortSeeder::class,
            StationSeeder::class,
            LoadPlaceSeeder::class,
            DeliveryPlaceSeeder::class,
            ReceiverSeeder::class,
            SenderSeeder::class,
            ShipmentSeeder::class,
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\LoadPlace;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LoadPlaceSeeder extends Seeder
{
    public $quantity = 40;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LoadPlace::factory($this->quantity)->create();

        foreach (Client::all() as $client) {
            for ($i = 1; $i <= $this->quantity; $i++) {
                $prob = rand(1, 10);
                if ($prob > 5) {
                    DB::table('client_load_place')->insert([
                        'client_id' => $client->id,
                        'load_place_id' => $i,
                    ]);
                }
            }
        }
    }
}

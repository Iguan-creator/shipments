<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Receiver;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReceiverSeeder extends Seeder
{
    public $quantity = 20;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Receiver::factory($this->quantity)->create();

        foreach (Client::all() as $client) {
            for ($i = 1; $i <= $this->quantity; $i++) {
                $prob = rand(1, 10);
                if ($prob > 5) {
                    DB::table('client_receiver')->insert([
                        'client_id' => $client->id,
                        'receiver_id' => $i,
                    ]);
                }
            }
        }
    }
}

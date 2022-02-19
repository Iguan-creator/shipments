<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Sender;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SenderSeeder extends Seeder
{
    public $quantity = 20;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sender::factory($this->quantity)->create();

        foreach (Client::all() as $client) {
            for ($i = 1; $i <= $this->quantity; $i++) {
                $prob = rand(1, 10);
                if ($prob > 5) {
                    DB::table('client_sender')->insert([
                        'client_id' => $client->id,
                        'sender_id' => $i,
                    ]);
                }
            }
        }
    }
}

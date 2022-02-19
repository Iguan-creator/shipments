<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Seller;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SellerSeeder extends Seeder
{
    public $quantity = 10;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Seller::factory($this->quantity)->create();

        foreach (config('ini_data.types') as $type_id => $type) {
            for ($i = 1; $i <= $this->quantity; $i++) {
                $prob = rand(1, 10);
                if ($prob > 4) {
                    DB::table('seller_type')->insert([
                        'seller_id' => $i,
                        'type_id' => $type_id,
                    ]);
                }
            }
        }

        foreach (Client::all() as $client) {
            for ($i = 1; $i <= $this->quantity; $i++) {
                $prob = rand(1, 10);
                if ($prob > 5) {
                    DB::table('client_seller')->insert([
                        'client_id' => $client->id,
                        'seller_id' => $i,
                    ]);
                }
            }
        }
    }
}

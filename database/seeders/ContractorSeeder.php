<?php

namespace Database\Seeders;

use App\Models\Contractor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContractorSeeder extends Seeder
{
    public $quantity = 20;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Contractor::factory($this->quantity)->create();

        foreach (config('ini_data.types') as $type_id => $type) {
            for ($i = 1; $i <= $this->quantity; $i++) {
                $prob = rand(1, 10);
                if ($prob > 5) {
                    DB::table('contractor_type')->insert([
                        'contractor_id' => $i,
                        'type_id' => $type_id,
                    ]);
                }
            }
        }
    }
}

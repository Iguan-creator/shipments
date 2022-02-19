<?php

namespace Database\Seeders;

use App\Models\Shipment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ShipmentSeeder extends Seeder
{
    public $quantity = 200;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < $this->quantity; $i++) {

            $shipment = Shipment::factory()->create();

            foreach ($shipment->type->buildRelationshipsArray() as $parameter) {
                $class_name = 'App\Models\Parameters\Shipment' . ucfirst($parameter);

                if (substr($class_name, -1) === 's') {
                    $class_name = Str::singular($class_name);
                    $quantity = rand(2, 3);
                } else {
                    $quantity = 1;
                }

                for ($q = 0; $q < $quantity; $q++) {
                    $class_name::factory()->create(['shipment_id' => $shipment->id]);
                }
            }

        }
    }
}

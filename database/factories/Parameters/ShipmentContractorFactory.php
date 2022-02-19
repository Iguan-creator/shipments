<?php

namespace Database\Factories\Parameters;

use App\Models\Contractor;
use App\Models\Parameters\ShipmentContractor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ShipmentContractorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ShipmentContractor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $contractors = Contractor::all(['id']);
        return [
            'contractor_id' => $contractors->random()->id,
        ];
    }
}

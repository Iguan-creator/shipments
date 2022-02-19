<?php

namespace App\Console\Commands;

use App\Models\Parameter;
use App\Models\Shipment;
use App\Models\Type;
use App\Models\User;
use App\Notifications\UnfilledShipments;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class CheckUnfilledShipments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check_unfilled_shipments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check database for unfilled shipments and notifies users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $users = User::where('id', '>', 1)->get();
        foreach ($users as $user) {
            $unfilled_shipments = $user->shipments()
                ->with('positionNumber')
                ->where('filled', false)
                ->get()->toArray();
            foreach ($unfilled_shipments as $index => &$unfilled_shipment) {
                $unfilled_params = [];
                $shipment = Shipment::find($unfilled_shipment['id']);
                $shipmentData = $shipment->load($shipment->type->buildRelationshipsArray())->type->parameters;
                foreach ($shipmentData as $parameter) {
                    if (!empty($parameter->required) == 1) {
                        if (empty($shipment->load($shipment->type->buildRelationshipsArray())->toArray()[$parameter->table])) {
                            $unfilled_params[] = $parameter->plural_name;
                        }
                    }
                }
                $unfilled_shipment['unfilled_fields'] = $unfilled_params;
            }
            $this->selectIdAndNumberOnly($unfilled_shipments, 'unfilled');
            $unfilled = $unfilled_shipments;

            if ($unfilled) {
                $user->notify(new UnfilledShipments($unfilled));
            }
        }
    }

    /**
     * Leave only ids and numbers in array
     *
     * @param array $array
     * @param string $type
     */
    protected function selectIdAndNumberOnly(array &$array, string $type)
    {
        array_walk($array, function (&$value) use ($type) {
            if (!empty($value['unfilled_fields'])) {
                $additionFields = $value['unfilled_fields'];
            }
            $value = [
                'id' => $value['id'],
                'position_number' => $value['position_number'],
                'type' => $type,
            ];
            if (isset($additionFields)) {
                $value['unfilled_fields'] = $additionFields;
            }
        });
    }
}

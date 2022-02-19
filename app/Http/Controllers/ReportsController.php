<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Parameters\ShipmentLoadDate;
use App\Models\Seller;
use App\Models\Shipment;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class ReportsController extends Controller
{
    /**
     * Shipments period selection field.
     */
    const DATA_FIELD = 'sendPlannedDate';

    /**
     * Report start date
     *
     * @var string
     */
    protected $from;

    /**
     * Report end date
     *
     * @var string
     */
    protected $to;

    /**
     * Dates to retrieve
     * @var array
     */
    protected $with = [
        'loadDate',
        'positionNumber',
        'sendActualDate',
        'sendPlannedDate',
        'arrivalActualDate',
        'arrivalPlanDate'
    ];

    public function __construct(Request $request)
    {
        $this->from = $request->has('from') ? Carbon::parse($request->input('from')) : now()->subMonth();
        $this->to = $request->has('to') ? Carbon::parse($request->input('to'))->addDay() : now();
    }

    /**
     * Get all shipments with QoS dates
     *
     * @return JsonResponse
     */
    public function overall()
    {
        $shipments = Shipment::query()
            ->with($this->with)
            ->whereHas('loadDate', function ($query) {
                $query->where('value', '>', $this->from)
                    ->where('value', '<', $this->to);
            })->get();

        return jsonResponse($shipments);
    }

    /**
     * Get data by client
     *
     * @param Client $client
     * @return JsonResponse
     */
    public function byClient(Client $client)
    {
        $shipments = Shipment::whereHas('loadDate', function ($query) {
            $query->where('value', '>', $this->from)
                ->where('value', '<', $this->to);
        })
            ->with($this->with)
            ->whereHas('client', function (Builder $query) use ($client) {
                $query->where('client_id', $client->id);
            })->get();

        return jsonResponse($shipments);
    }

    /**
     * Get data by Employee
     *
     * @param User $user
     * @return JsonResponse
     */
    public function byEmployee(User $user)
    {
        $shipments = Shipment::whereHas('loadDate', function ($query) {
            $query->where('value', '>', $this->from)
                ->where('value', '<', $this->to);
        })
            ->with($this->with)
            ->where('user_id', $user->id)->get();

        return jsonResponse($shipments);
    }

    /**
     * Get data by seller
     *
     * @param Seller $seller
     * @return JsonResponse
     *
     */
    public function bySeller(Seller $seller)
    {
        $shipments = Shipment::whereHas('loadDate', function ($query) {
            $query->where('value', '>', $this->from)
                ->where('value', '<', $this->to);
        })
            ->with($this->with)
            ->whereHas('client.value.sellers', function (Builder $query) use ($seller) {
                $query->where('id', $seller->id);
            })->get();

        return jsonResponse($shipments);
    }

    /**
     * Get a list of all clients for building a report
     *
     * @return JsonResponse
     */
    public function indexClients()
    {
        $clients = Client::all();

        return jsonResponse($clients);
    }

    /**
     * Get a list of all employees for building a report
     *
     * @return JsonResponse
     */
    public function indexEmployees()
    {
        $employees = User::select(['id', 'first_name', 'last_name'])
            ->get();

        $employees = $employees->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
            ];
        });

        return jsonResponse($employees);
    }

    /**
     * Get a list of all sellers for building a report
     *
     * @return JsonResponse
     */
    public function indexSellers()
    {
        $employees = Seller::all();

        return jsonResponse($employees);
    }

    /**
     * Custom flexible report request.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function custom(Request $request)
    {
        $shipment_ids = false;

        $routeParameters = ['airports', 'ports', 'stations'];

        foreach ($request->all() as $parameter => $value) {
            if (!$value || $parameter === 'from' || $parameter === 'to') {
                continue;
            }

            if ($parameter === 'types') {

                $collection = Shipment::whereIn('type_id', $value)->get();
                $ids = $collection->pluck('id')->toArray();

            } else if (in_array($parameter, $routeParameters)) {

                $any_ids = [];
                $arrival_ids = [];
                $send_ids = [];

                if (isset($value['any'])) {
                    $any_ids = $this->getShipmentIdsByParameterList($parameter, $value['any']);
                }

                if (isset($value['arrival'])) {
                    $all_ids = $this->getShipmentIdsByParameterList($parameter, $value['arrival']);
                    $shipments = Shipment::with($parameter)->findMany($all_ids);
                    $shipments = $shipments->filter(function ($shipment) use ($parameter, $value) {
                        $total = count($shipment->$parameter);
                        $index = Str::singular($parameter) . '_id';
                        return in_array($shipment->$parameter[$total - 1]->$index, $value['arrival']);
                    });
                    $arrival_ids = $shipments->pluck('id')->toArray();
                }

                if (isset($value['send'])) {
                    $all_ids = $this->getShipmentIdsByParameterList($parameter, $value['send']);
                    $shipments = Shipment::with($parameter)->findMany($all_ids);
                    $shipments = $shipments->filter(function ($shipment) use ($parameter, $value) {
                        $index = Str::singular($parameter) . '_id';
                        return in_array($shipment->$parameter[0]->$index, $value['send']);
                    });
                    $send_ids = $shipments->pluck('id')->toArray();
                }

                $ids = array_merge($any_ids, $arrival_ids, $send_ids);

                if (!$ids) {
                    continue;
                }

            } else if ($parameter === 'sellers') {

                $transitionModelIds = Client::whereHas('sellers', function ($query) use ($value) {
                    $query->whereIn('id', $value);
                })->get()->pluck('id')->toArray();

                $ids = $this->getShipmentIdsByParameterList('clients', $transitionModelIds);

            } else if ($parameter === 'users') {

                $ids = Shipment::select(['id', 'user_id'])
                    ->whereIn('user_id', $value, 'or')
                    ->get()
                    ->pluck('id')
                    ->toArray();

            } else {
                $ids = $this->getShipmentIdsByParameterList($parameter, $value);
            }

            if ($shipment_ids === false) {
                $shipment_ids = $ids;
            } else {
                $shipment_ids = array_intersect($shipment_ids, $ids);
            }
        }

        $results = Shipment::query()
            ->with($this->with)
            ->whereIn('id', $shipment_ids)
            ->whereHas('loadDate', function ($query) {
                $query->where('value', '>', $this->from)
                    ->where('value', '<', $this->to);
            })->get();

        return jsonResponse($results);
    }

    /**
     * Receive shipment ids by a list of certain dependencies
     *
     * @param string $parameter
     * @param array $values
     * @return mixed
     */
    protected function getShipmentIdsByParameterList(string $parameter, array $values)
    {
        $from = $this->from;
        $to = $this->to;

        $singularName = Str::singular($parameter);
        $modelName = '\App\Models\Parameters\Shipment' . Str::ucfirst(Str::camel($singularName));

        $collection = $modelName::whereIn($singularName . '_id', $values)
            ->with('shipment.' . self::DATA_FIELD)
            ->whereHas('shipment.' . self::DATA_FIELD, function ($query) use ($from, $to) {
                $query->whereBetween('value', [$from, $to]);
            })
            ->get();

        return $collection->pluck('shipment_id')->toArray();
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeOwnerShipment;
use App\Http\Requests\DeliveredShipmentsRequest;
use App\Http\Requests\DocumentsSentRequest;
use App\Http\Requests\FinishedRequest;
use App\Http\Requests\ShipmentFinishRequest;
use App\Models\Parameter;
use App\Models\Parameters\ShipmentPositionNumber;
use App\Models\Shipment;
use App\Models\Type;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use ReflectionException;

class ShipmentController extends Controller
{
    const DEFAULT_LAST_MONTHS = 6;

    /**
     * Shipments start date
     *
     * @var string
     */
    protected $from;

    /**
     * Shipments end date
     *
     * @var string
     */
    protected $to;

    public function __construct(Request $request)
    {
        $this->authorizeResource(Shipment::class, 'shipment');
        $this->from = $request->has('from') ? Carbon::parse($request->input('from')) : now()->subMonths(self::DEFAULT_LAST_MONTHS);
        $this->to = $request->has('to') ? Carbon::parse($request->input('to'))->addDay() : now()->addDay();
    }

    /**
     * Get all shipments by a certain type
     *
     * @param Type $type
     * @return JsonResponse
     */
    public function getAllByType(Type $type, FinishedRequest $request)
    {
        $query = Shipment::filterByDates($this->from, $this->to)
            ->with($type->buildRelationshipsArray())
            ->with('user')
            ->where('type_id', $type->id);

        if ($request->has('finished')) {
            $query->where('finished', $request->finished);
        }

        return jsonResponse($query->get());
    }

    /**
     * Get shipments for a certain user by a certain type
     *
     * @param Type $type
     * @param User $user
     * @return JsonResponse
     */
    public function getUserByType(Type $type, User $user, FinishedRequest $request)
    {
        $query = Shipment::filterByDates($this->from, $this->to)
            ->with($type->buildRelationshipsArray())
            ->where('type_id', $type->id)
            ->where('user_id', $user->id);

        if ($request->has('finished')) {
            $query->where('finished', $request->finished);
        }

        return jsonResponse($query->get());
    }

    /**
     * Get shipments for the current user by a certain type.
     *
     * @param Type $type
     * @return JsonResponse
     */
    public function getMyByType(Type $type, FinishedRequest $request)
    {
        $user_id = Auth::check() ? Auth::id() : 0;

        $query = Shipment::filterByDates($this->from, $this->to)
            ->with($type->buildRelationshipsArray())
            ->where('type_id', $type->id)
            ->where('user_id', $user_id);

        if ($request->has('finished')) {
            $query->where('finished', $request->finished);
        }

        return jsonResponse($query->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ReflectionException
     */
    public function store(Request $request)
    {
        $filled = true;

        $shipment = new Shipment();
        $shipment->type_id = $request->input('type_id');
        $shipment->user_id = Auth::id();
        $shipment->save();

        $type = Type::find($request->input('type_id'));
        $parameters = $type->buildRelationshipsArray();
        $this->statusFilledRequestFields($request, $parameters,$filled, $shipment);
        foreach ($parameters as $parameter) {
            $many = substr($parameter, -1) === 's';

            $shipment_parameter_class_name = 'App\Models\Parameters\Shipment' . ucfirst(Str::singular($parameter));
            $reflection = new \ReflectionClass($shipment_parameter_class_name);
            $related = $reflection->hasMethod('relatedModel');


            $index = $related ? Str::snake(Str::singular($parameter)) . '_id' : 'value';

            if ($many) {
                $input_data = Arr::pluck($request->input(Str::snake($parameter)), $index);
                $input_data = array_filter($input_data, function ($value) {
                    return $value;
                });

                foreach ($input_data as $input_value) {
                    if ($input_value) {
                        $shipment->$parameter()->create([$index => $input_value]);
                    }
                }
            } else {
                $shipment->$parameter()->create([$index => $request->input(Str::snake($parameter))]);
            }
        }

        $shipment->filled = $filled;
        $shipment->save();

        return jsonResponse($shipment->id);
    }

    /**
     * Display the specified resource.
     *
     * @param Shipment $shipment
     * @return JsonResponse
     */
    public function show(Shipment $shipment)
    {
        $shipment
            ->load($shipment->type->buildRelationshipsArray())
            ->load('user');

        return jsonResponse($shipment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Shipment $shipment
     * @return string
     * @throws ReflectionException
     */
    public function update(Request $request, Shipment $shipment)
    {
        $filled = true;

        $type = Type::find($shipment->type_id);
        $parameters = $type->buildRelationshipsArray();
        $this->statusFilledRequestFields($request, $parameters,$filled, $shipment);
        foreach ($parameters as $parameter) {
            $many = substr($parameter, -1) === 's';



            $shipment_parameter_class_name = 'App\Models\Parameters\Shipment' . ucfirst(Str::singular($parameter));
            $reflection = new \ReflectionClass($shipment_parameter_class_name);
            $related = $reflection->hasMethod('relatedModel');

            $index = $related ? Str::snake(Str::singular($parameter)) . '_id' : 'value';

            if ($many) {
                $input_data = Arr::pluck($request->input(Str::snake($parameter)), $index);
                $current_values = Arr::pluck($shipment->$parameter, 'value.id');
                if ($input_data !== $current_values) {
                    foreach ($current_values as $remove) {
                        $shipment->$parameter()->where($index, $remove)->delete();
                    }
                    foreach ($input_data as $add) {
                        if ($add) {
                            $shipment->$parameter()->create([$index => $add]);
                        }
                    }
                }
                $shipment->load($parameter);
            } else {
                $shipment_parameter = $shipment->$parameter()->exists() ? $shipment->$parameter : new $shipment_parameter_class_name;
                $shipment_parameter->shipment_id = $shipment->id;
                $shipment_parameter->$index = $request->input(Str::snake($parameter));
                $shipment_parameter->save();
            }
        }

        $shipment->filled = $filled;
        $shipment->save();

        return 'Success';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Shipment $shipment
     * @return string
     * @throws Exception
     */
    public function destroy(Shipment $shipment)
    {
        $shipment->delete();

        return 'Success';
    }

    /**
     * Make documents sent
     *
     * @param DocumentsSentRequest $request
     * @param Shipment $shipment
     * @return string
     */
    public function documentsSent(DocumentsSentRequest $request, Shipment $shipment)
    {
        $shipment->documents_sent = $request->sent;
        $shipment->save();

        return 'Success';
    }

    /**
     * Get current type parameters
     *
     * @param Type $type
     * @return JsonResponse
     */
    public function getTypeParameters(Type $type)
    {
        return jsonResponse($type->parameters);
    }

    /**
     * Finish shipment by it's position number request.
     *
     * @param ShipmentFinishRequest $request
     * @return string
     */
    public function shipmentFinish(ShipmentFinishRequest $request)
    {
        $positionNumbers = ShipmentPositionNumber::where('value', $request->position_number)
            ->with('shipment')
            ->get();

        if (!$positionNumbers) {
            return response('Position number does not exist', 200);
        }

        foreach ($positionNumbers as $positionNumber) {
            $positionNumber->shipment->finish();
        }

        return 'Success';
    }

    /**
     * Return position numbers and delivery actual dates for 1s
     *
     * @param DeliveredShipmentsRequest $request
     * @return JsonResponse
     */
    public function deliveredShipments(DeliveredShipmentsRequest $request)
    {
        $query = Shipment::with(['positionNumber', 'deliveryActualDate'])
            ->select('id')
            ->whereHas('deliveryActualDate', function ($query) {
                $query->where('value', '!=', null);
            });

        $from = $request->from ?
            Carbon::parse($request->from)->toDateTimeString() :
            now()->subHours(2)->toDateTimeString();

        $query->where('updated_at', '>', $from);

        $shipments = $query->get();
        $shipments->makeHidden('id');

        return jsonResponse($shipments);
    }

    /**
     * Изменяет владельца перевозки
     *
     * @param ChangeOwnerShipment $request
     * @param Shipment $shipment
     * @return string
     */
    public function changeOwner(ChangeOwnerShipment $request, Shipment $shipment)
    {

        $shipment->user_id = $request->user_id;
        $shipment->save();

        return 'Success';

    }

    /**
     * Проверка наличия записи в таблице shipment_position_numbers по value $request->input('position_number)
     *
     * @param Request $request
     * @return bool
     */
    public function shipment_exists(Request $request)
    {
        return ShipmentPositionNumber::where('value', $request->input('position_number'))
            ->exists();
    }

    /**
     * Проверка заполненности полей Request
     *
     * @param Request $request
     * @param $parameters
     * @param $filled
     * @param Shipment $shipment
     * @return mixed
     */
    private function statusFilledRequestFields(Request $request, $parameters, &$filled, Shipment $shipment)
    {
        $requiredParams = $shipment
            ->load($shipment->type->buildRelationshipsArray())->type->parameters;
        foreach ($parameters as $index => $parameter) {
            $parameter = Str::snake($parameter);
            foreach ($requiredParams as $i => $requiredParam) {
                if ($requiredParam->table == $parameter && !empty($requiredParam->required)) {
                    if (is_array($request->{$parameter})) {
                        foreach ($request->{$parameter} as $param) {
                            if (empty($param[array_key_first($param)])) {
                                $filled = false;
                                break 3;
                            }
                        }
                    } else {
                        if (empty($request->{$parameter})) {
                            $filled = false;
                            break 2;
                        }
                    }
                }
            }
        }
    }
}

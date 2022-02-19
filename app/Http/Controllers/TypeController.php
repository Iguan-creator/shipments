<?php

namespace App\Http\Controllers;

use App\Models\Airport;
use App\Models\Car;
use App\Models\Container;
use App\Models\Contractor;
use App\Models\Parameter;
use App\Models\Port;
use App\Models\Seller;
use App\Models\Station;
use App\Models\Type;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Type::class, 'type');
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $types = Type::without('parameters')->get();
        return jsonResponse($types);
    }

    /**
     * Display one resource
     *
     * @param Type $type
     * @return JsonResponse
     */
    public function show(Type $type)
    {
        return jsonResponse($type);
    }

    /**
     * Update current Type instance data
     *
     * @param Request $request
     * @param Type $type
     * @return string
     */
    public function update(Request $request, Type $type)
    {
        $type->update($request->all());

        return 'Success';
    }

    /**
     * @param Type $type
     * @return JsonResponse
     */
    public function getParameterDependencies(Type $type)
    {
        $parameters = Parameter::all(['id', 'plural_name as name']);
        $checked = $type->parameters->pluck('id');

        addCheckedToCollection($parameters, $checked);

        return jsonResponse($parameters);
    }

    /**
     * @param Request $request
     * @param Type $type
     * @return string
     */
    public function setParameterDependencies(Request $request, Type $type)
    {
        $type->parameters()->sync($request->input('data'));

        return 'Success';
    }

    /**
     * @param Type $type
     * @return JsonResponse
     */
    public function getSellerDependencies(Type $type)
    {
        $sellers = Seller::orderBy('name')->get(['id', 'name']);
        $checked = $type->sellers->pluck('id');

        addCheckedToCollection($sellers, $checked);

        return jsonResponse($sellers);
    }

    /**
     * @param Request $request
     * @param Type $type
     * @return string
     */
    public function setSellerDependencies(Request $request, Type $type)
    {
        $type->sellers()->sync($request->input('data'));

        return 'Success';
    }

    /**
     * @param Type $type
     * @return JsonResponse
     */
    public function getContractorDependencies(Type $type)
    {
        $contractors = Contractor::orderBy('name')->get(['id', 'name']);
        $checked = $type->contractors->pluck('id');

        addCheckedToCollection($contractors, $checked);

        return jsonResponse($contractors);
    }

    /**
     * @param Request $request
     * @param Type $type
     * @return string
     */
    public function setContractorDependencies(Request $request, Type $type)
    {
        $type->contractors()->sync($request->input('data'));

        return 'Success';
    }

    /**
     * @param Type $type
     * @return JsonResponse
     */
    public function getCarDependencies(Type $type)
    {
        $cars = Car::orderBy('name')->get(['id', 'name']);
        $checked = $type->cars->pluck('id');

        addCheckedToCollection($cars, $checked);

        return jsonResponse($cars);
    }

    /**
     * @param Request $request
     * @param Type $type
     * @return string
     */
    public function setCarDependencies(Request $request, Type $type)
    {
        $type->cars()->sync($request->input('data'));

        return 'Success';
    }

    /**
     * @param Type $type
     * @return JsonResponse
     */
    public function getContainerDependencies(Type $type)
    {
        $containers = Container::orderBy('name')->get(['id', 'name']);
        $checked = $type->containers->pluck('id');

        addCheckedToCollection($containers, $checked);

        return jsonResponse($containers);
    }

    /**
     * @param Request $request
     * @param Type $type
     * @return string
     */
    public function setContainerDependencies(Request $request, Type $type)
    {
        $type->containers()->sync($request->input('data'));

        return 'Success';
    }

    /**
     * @param Type $type
     * @return JsonResponse
     */
    public function getAirportDependencies(Type $type)
    {
        $airports = Airport::orderBy('name')->get(['id', 'name']);
        $checked = $type->airports->pluck('id');

        addCheckedToCollection($airports, $checked);

        return jsonResponse($airports);
    }

    /**
     * @param Request $request
     * @param Type $type
     * @return string
     */
    public function setAirportDependencies(Request $request, Type $type)
    {
        $type->airports()->sync($request->input('data'));

        return 'Success';
    }

    /**
     * @param Type $type
     * @return JsonResponse
     */
    public function getPortDependencies(Type $type)
    {
        $ports = Port::orderBy('name')->get(['id', 'name']);
        $checked = $type->ports->pluck('id');

        addCheckedToCollection($ports, $checked);

        return jsonResponse($ports);
    }

    /**
     * @param Request $request
     * @param Type $type
     * @return string
     */
    public function setPortDependencies(Request $request, Type $type)
    {
        $type->ports()->sync($request->input('data'));

        return 'Success';
    }

    /**
     * @param Type $type
     * @return JsonResponse
     */
    public function getStationDependencies(Type $type)
    {
        $stations = Station::orderBy('name')->get(['id', 'name']);
        $checked = $type->stations->pluck('id');

        addCheckedToCollection($stations, $checked);

        return jsonResponse($stations);
    }

    /**
     * @param Request $request
     * @param Type $type
     * @return string
     */
    public function setStationDependencies(Request $request, Type $type)
    {
        $type->stations()->sync($request->input('data'));

        return 'Success';
    }
}

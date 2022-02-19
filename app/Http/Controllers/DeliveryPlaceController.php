<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\DeliveryPlace;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeliveryPlaceController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(DeliveryPlace::class, 'delivery_place');
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index($typeId = null)
    {
        if ($typeId) {
            $deliveryPlaces = DeliveryPlace::orderByDesc("frequency_{$typeId}")
                ->orderBy('name')
                ->get();
        } else {
            $deliveryPlaces = DeliveryPlace::orderBy('name')
                ->get();
        }

        return jsonResponse($deliveryPlaces);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response|string
     */
    public function store(Request $request)
    {
        $recordExists = DeliveryPlace::where('name', $request->input('name'))
            ->exists();

        if ($recordExists) {
            return response('Already exists', 409);
        }

        $delivery_place = DeliveryPlace::create($request->all());

        $clientIds = Client::all('id')->pluck('id');
        $delivery_place->clients()->sync($clientIds);
        return jsonResponse($delivery_place);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param DeliveryPlace $deliveryPlace
     * @return string
     */
    public function update(Request $request, DeliveryPlace $deliveryPlace)
    {
        $deliveryPlace->update($request->all());

        return 'Success';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeliveryPlace $deliveryPlace
     * @return string
     * @throws Exception
     */
    public function destroy(DeliveryPlace $deliveryPlace)
    {
        $deliveryPlace->delete();

        return 'Success';
    }

    /**
     * Get delivery places by the client
     *
     * @param Client $client
     * @return JsonResponse
     */
    public function getDeliveryPlacesByClient(Client $client)
    {
        return jsonResponse($client->deliveryPlaces);
    }
}

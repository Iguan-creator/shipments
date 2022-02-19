<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewClientRequest;
use App\Models\Client;
use App\Models\DeliveryPlace;
use App\Models\LoadPlace;
use App\Models\Receiver;
use App\Models\Seller;
use App\Models\Sender;
use Illuminate\Http\JsonResponse as HttpJsonResponse;
use Exception;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Client::class, 'client');
    }

    /**
     * Display a listing of the resource.
     *
     * @return HttpJsonResponse
     */
    public function index($typeId = null)
    {
        if ($typeId) {
            $clients = Client::orderByDesc("frequency_{$typeId}")
                ->orderBy('name')
                ->get();
        } else
            $clients = Client::orderBy('name')->get();

        return jsonResponse($clients);

    }

    /**
     * Display one resource
     *
     * @param Client $client
     * @return HttpJsonResponse
     */
    public function show(Client $client)
    {

        return jsonResponse($client);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response|HttpJsonResponse
     */
    public function store(Request $request)
    {
        $recordExists = Client::where('name', $request->input('name'))
            ->exists();

        if ($recordExists) {
            return response('Already exists', 409);
        }

        $client = Client::create($request->all());
        return jsonResponse($client);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Client $client
     * @return string
     */
    public function update(Request $request, Client $client)
    {
        $client->update($request->all());

        return 'Success';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Client $client
     * @return string
     * @throws Exception
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return 'Success';
    }

    /**
     * @param Client $client
     * @return HttpJsonResponse
     */
    public function getSellerDependencies(Client $client)
    {
        $sellers = Seller::all();
        $checked = $client->sellers->pluck('id');

        addCheckedToCollection($sellers, $checked);

        return jsonResponse($sellers);
    }

    /**
     * @param Request $request
     * @param Client $client
     * @return string
     */
    public function setSellerDependencies(Request $request, Client $client)
    {
        $client->sellers()->sync($request->input('data'));

        return 'Success';
    }

    /**
     * @param Client $client
     * @return HttpJsonResponse
     */
    public function getLoadPlaceDependencies(Client $client)
    {
        $loadPlaces = LoadPlace::orderBy('name')->get();
        $checked = $client->loadPlaces->pluck('id');

        addCheckedToCollection($loadPlaces, $checked);

        return jsonResponse($loadPlaces);
    }

    /**
     * @param Request $request
     * @param Client $client
     * @return string
     */
    public function setLoadPlaceDependencies(Request $request, Client $client)
    {
        $client->loadPlaces()->sync($request->input('data'));

        return 'Success';
    }

    /**
     * @param Client $client
     * @return HttpJsonResponse
     */
    public function getDeliveryPlaceDependencies(Client $client)
    {
        $deliveryPlaces = DeliveryPlace::orderBy('name')->get();
        $checked = $client->deliveryPlaces->pluck('id');

        addCheckedToCollection($deliveryPlaces, $checked);

        return jsonResponse($deliveryPlaces);
    }

    /**
     * @param Request $request
     * @param Client $client
     * @return string
     */
    public function setDeliveryPlaceDependencies(Request $request, Client $client)
    {
        $client->deliveryPlaces()->sync($request->input('data'));

        return 'Success';
    }

    /**
     * @param Client $client
     * @return HttpJsonResponse
     */
    public function getReceiverDependencies(Client $client)
    {
        $receivers = Receiver::orderBy('name')->get();
        $checked = $client->receivers->pluck('id');

        addCheckedToCollection($receivers, $checked);

        return jsonResponse($receivers);
    }

    /**
     * @param Request $request
     * @param Client $client
     * @return string
     */
    public function setReceiverDependencies(Request $request, Client $client)
    {
        $client->receivers()->sync($request->input('data'));

        return 'Success';
    }

    /**
     * @param Client $client
     * @return HttpJsonResponse
     */
    public function getSenderDependencies(Client $client)
    {
        $senders = Sender::orderBy('name')->get();
        $checked = $client->senders->pluck('id');

        addCheckedToCollection($senders, $checked);

        return jsonResponse($senders);
    }

    /**
     * @param Request $request
     * @param Client $client
     * @return string
     */
    public function setSenderDependencies(Request $request, Client $client)
    {
        $client->senders()->sync($request->input('data'));

        return 'Success';
    }

    /**
     * @param NewClientRequest $request
     * @return HttpJsonResponse
     */
    public function newClientFromOneS(NewClientRequest $request)
    {
        return $this->store($request);
    }
}

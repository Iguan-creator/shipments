<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\LoadPlace;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoadPlaceController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(LoadPlace::class, 'load_place');
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index($tyepId = null)
    {
        if ($tyepId) {
            $loadPlaces = LoadPlace::orderByDesc("frequency_{$tyepId}")
                ->orderBy('name')
                ->get();
        } else {
            $loadPlaces = LoadPlace::orderBy('name')
                ->get();
        }

        return jsonResponse($loadPlaces);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response|string
     */
    public function store(Request $request)
    {
        $recordExists = LoadPlace::where('name', $request->input('name'))
            ->exists();

        if ($recordExists) {
            return response('Already exists', 409);
        }

        $load_place = LoadPlace::create($request->all());

        $clientIds = Client::all('id')->pluck('id');
        $load_place->clients()->sync($clientIds);

        return jsonResponse($load_place);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param LoadPlace $loadPlace
     * @return string
     */
    public function update(Request $request, LoadPlace $loadPlace)
    {
        $loadPlace->update($request->all());

        return 'Success';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param LoadPlace $loadPlace
     * @return string
     * @throws Exception
     */
    public function destroy(LoadPlace $loadPlace)
    {
        $loadPlace->delete();

        return 'Success';
    }

    /**
     * Get load places by the client
     *
     * @param Client $client
     * @return JsonResponse
     */
    public function getLoadPlacesByClient(Client $client)
    {
        return jsonResponse($client->loadPlaces);
    }
}

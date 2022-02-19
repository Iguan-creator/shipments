<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Sender;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SenderController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Sender::class, 'sender');
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index($typeId = null)
    {
        if ($typeId) {
            $loadPlaces = Sender::orderByDesc("frequency_{$typeId}")
                ->orderBy('name')
                ->get();
        } else {
            $loadPlaces = Sender::orderBy('name')
                ->get();
        }


        return jsonResponse($loadPlaces);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response|JsonResponse
     */
    public function store(Request $request)
    {
        $recordExists = Sender::where('name', $request->input('name'))
            ->exists();

        if ($recordExists) {
            return response('Already exists', 409);
        }

        $sender = Sender::create($request->all());

        $clientIds = Client::all('id')->pluck('id');
        $sender->clients()->sync($clientIds);

        return jsonResponse($sender);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Sender $sender
     * @return string
     */
    public function update(Request $request, Sender $sender)
    {
        $sender->update($request->all());

        return 'Success';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Sender $sender
     * @return string
     * @throws Exception
     */
    public function destroy(Sender $sender)
    {
        $sender->delete();

        return 'Success';
    }

    /**
     * Get load places by the client
     *
     * @param Client $client
     * @return JsonResponse
     */
    public function getSendersByClient(Client $client)
    {
        return jsonResponse($client->senders);
    }
}

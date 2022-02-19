<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Receiver;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReceiverController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Receiver::class, 'receiver');
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index($typeId = null)
    {
        if ($typeId) {
            $receivers = Receiver::orderByDesc("frequency_{$typeId}")
                ->orderBy('name')
                ->get();
        } else {
            $receivers = Receiver::orderBy('name')
                ->get();

        }

        return jsonResponse($receivers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $recordExists = Receiver::where('name', $request->input('name'))
            ->exists();

        if ($recordExists) {
            return response('Already exists', 409);
        }

        $receiver = Receiver::create($request->all());

        $clientIds = Client::all('id')->pluck('id');
        $receiver->clients()->sync($clientIds);

        return jsonResponse($receiver);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Receiver $receiver
     * @return string
     */
    public function update(Request $request, Receiver $receiver)
    {
        $receiver->update($request->all());

        return 'Success';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Receiver $receiver
     * @return string
     * @throws Exception
     */
    public function destroy(Receiver $receiver)
    {
        $receiver->delete();

        return 'Success';
    }

    /**
     * Get load places by the client
     *
     * @param Client $client
     * @return JsonResponse
     */
    public function getReceiversByClient(Client $client)
    {
        return jsonResponse($client->receivers);
    }
}

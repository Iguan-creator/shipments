<?php

namespace App\Http\Controllers;

use App\Models\Port;
use App\Models\Type;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PortController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Port::class, 'port');
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index($typeId = null)
    {
        if ($typeId) {
            $ports = Port::orderByDesc("frequency_{$typeId}")
                ->orderBy('name')
                ->get();
        } else {
            $ports = Port::orderBy('name')
                ->get();
        }

        return jsonResponse($ports);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response|string
     */
    public function store(Request $request)
    {
        $recordExists = Port::where('name', $request->input('name'))
            ->exists();

        if ($recordExists) {
            return response('Already exists', 409);
        }

        $port = Port::create($request->all());

        $port->types()->sync([1, 2, 3, 4, 6, 7, 10]);
        return jsonResponse($port);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Port $port
     * @return string
     */
    public function update(Request $request, Port $port)
    {
        $port->update($request->all());

        return 'Success';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Port $port
     * @return string
     * @throws Exception
     */
    public function destroy(Port $port)
    {
        $port->delete();

        return 'Success';
    }

    /**
     * Get ports by the type
     *
     * @param Type $type
     * @return JsonResponse
     */
    public function getPortsByType(Type $type)
    {
        return jsonResponse($type->ports()->orderByDesc('frequency_'.$type->id)->get());
    }
}

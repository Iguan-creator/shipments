<?php

namespace App\Http\Controllers;

use App\Models\Station;
use App\Models\Type;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StationController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Station::class, 'station');
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index($typeId = null)
    {
        if ($typeId) {
            $stations = Station::orderByDesc("frequency_{$typeId}")
                ->orderBy('name')
                ->get();
        } else {
            $stations = Station::orderBy('name')
                ->get();
        }

        return jsonResponse($stations);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response|string
     */
    public function store(Request $request)
    {
        $recordExists = Station::where('name', $request->input('name'))
            ->exists();

        if ($recordExists) {
            return response('Already exists', 409);
        }

        $station = Station::create($request->all());

        $station->types()->sync([2, 3, 4, 6, 7, 8, 9, 10]);
        return jsonResponse($station);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Station $station
     * @return string
     */
    public function update(Request $request, Station $station)
    {
        $station->update($request->all());

        return 'Success';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Station $station
     * @return string
     * @throws Exception
     */
    public function destroy(Station $station)
    {
        $station->delete();

        return 'Success';
    }

    /**
     * Get stations by the type
     *
     * @param Type $type
     * @return JsonResponse
     */
    public function getStationsByType(Type $type)
    {
        return jsonResponse($type->stations()->orderByDesc('frequency_'.$type->id)->get());
    }
}

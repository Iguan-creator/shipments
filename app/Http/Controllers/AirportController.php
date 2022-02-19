<?php

namespace App\Http\Controllers;

use App\Models\Airport;
use App\Models\Type;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class AirportController
 *
 * @package App\Http\Controllers
 */
class AirportController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Airport::class, 'airport');
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index($typeId = null)
    {
        if ($typeId) {
            $airports = Airport::orderByDesc("frequency_{$typeId}")
                ->orderBy('name')
                ->get();
        } else
            $airports = Airport::orderBy('name')->get();

        return jsonResponse($airports);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response|string
     */
    public function store(Request $request)
    {
        $recordExists = Airport::where('name', $request->input('name'))
            ->exists();

        if ($recordExists) {
            return response('Already exists', 409);
        }

        $airport = Airport::create($request->all());

        $airport->types()->sync([3, 4, 5, 6, 7, 10]);
        return jsonResponse($airport);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Airport $airport
     * @return string
     */
    public function update(Request $request, Airport $airport)
    {
        $airport->update($request->all());

        return 'Success';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Airport $airport
     * @return string
     * @throws Exception
     */
    public function destroy(Airport $airport)
    {
        $airport->delete();

        return 'Success';
    }

    /**
     * Get airports by the type
     *
     * @param Type $type
     * @return JsonResponse
     */
    public function getAirportsByType(Type $type)
    {
        return jsonResponse($type->airports()->orderByDesc('frequency_'.$type->id)->get());
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Type;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index($typeId = null)
    {
        if ($typeId) {
            $cars = Car::orderByDesc("frequency_{$typeId}")
                ->orderBy('name')
                ->get();
        } else {
            $cars = Car::orderBy('name')
                ->get();
        }

        return jsonResponse($cars);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response|string
     */
    public function store(Request $request)
    {
        $recordExists = Car::where('name', $request->input('name'))
            ->exists();

        if ($recordExists) {
            return response('Already exists', 409);
        }

        $car = Car::create($request->all());

        $car->types()->sync([3, 4, 7, 10, 11]);
        return jsonResponse($car);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Car $car
     * @return string
     */
    public function update(Request $request, Car $car)
    {
        $car->update($request->all());

        return 'Success';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Car $car
     * @return string
     * @throws Exception
     */
    public function destroy(Car $car)
    {
        $car->delete();

        return 'Success';
    }

    /**
     * Get car types by the type
     *
     * @param Type $type
     * @return JsonResponse
     */
    public function getCarsByType(Type $type)
    {
        return jsonResponse($type->cars()->orderByDesc('frequency_'.$type->id)->get());
    }
}

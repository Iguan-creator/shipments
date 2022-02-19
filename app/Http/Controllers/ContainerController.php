<?php

namespace App\Http\Controllers;

use App\Models\Container;
use App\Models\Type;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContainerController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Container::class, 'container');
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index($typeId = null)
    {
        if ($typeId) {
            $containers = Container::orderByDesc("frequency_{$typeId}")
                ->select('id', 'name')
                ->orderBy('name')
                ->get();
        } else {
            $containers = Container::select('id', 'name')
                ->orderBy('name')
                ->get();
        }

        return jsonResponse($containers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response|string
     */
    public function store(Request $request)
    {
        $recordExists = Container::where('name', $request->input('name'))
            ->exists();

        if ($recordExists) {
            return response('Already exists', 409);
        }

        $container = Container::create($request->all());
        $container->types()->sync([2, 3, 4, 6, 7, 8, 9, 10]);

        return jsonResponse($container);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Container $container
     * @return string
     */
    public function update(Request $request, Container $container)
    {
        $container->update($request->all());

        return 'Success';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Container $container
     * @return string
     * @throws Exception
     */
    public function destroy(Container $container)
    {
        $container->delete();

        return 'Success';
    }

    /**
     * Get containers types by the type
     *
     * @param Type $type
     * @return JsonResponse
     */
    public function getContainersByType(Type $type)
    {
        return jsonResponse($type->containers()->orderByDesc('frequency_'.$type->id)->get());
    }
}

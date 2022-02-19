<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewContractorRequest;
use App\Models\Contractor;
use App\Models\Type;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContractorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index($typeId = null)
    {
        if ($typeId) {
            $contractors = Contractor::orderByDesc("frequency_{$typeId}")
                ->orderBy('name')
                ->get();
        } else {
            $contractors = Contractor::orderBy('name')
                ->get();
        }

        return jsonResponse($contractors);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return string
     */
    public function store(Request $request)
    {
        $recordExists = Contractor::where('name', $request->input('name'))
            ->exists();

        if ($recordExists) {
            return response('Already exists', 409);
        }

        $contractor = Contractor::create($request->all());

        $contractor->types()->sync(range(1, 11));
        return jsonResponse($contractor);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Contractor $contractor
     * @return string
     */
    public function update(Request $request, Contractor $contractor)
    {
        $contractor->update($request->all());

        return 'Success';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Contractor $contractor
     * @return string
     * @throws Exception
     */
    public function destroy(Contractor $contractor)
    {
        $contractor->delete();

        return 'Success';
    }

    /**
     * Get contractors by the type
     *
     * @param Type $type
     * @return JsonResponse
     */
    public function getContractorsByType(Type $type)
    {
        return jsonResponse($type->contractors()->orderByDesc('frequency_'.$type->id)->get());
    }

    /**
     * Метод добавляет нового подрядчика если его уже нет в базе, в противном случае выдает статус 409 и сообщение 'Contractor already exists'
     *
     * @param NewContractorRequest $request
     * @return \Illuminate\Http\Response|string
     */
    public function newContractorFromOneS(NewContractorRequest $request)
    {
        if (Contractor::where('name', '=', $request->input('name'))->first()) {

            return response('Contractor already exists', 409);

        } else {

            return $this->store($request);

        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Seller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Seller::class, 'seller');
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index($typeId = null)
    {
        if ($typeId) {
            $sellers = Seller::orderByDesc("frequency_{$typeId}")
                ->orderBy('name')
                ->get();
        } else {
            $sellers = Seller::orderBy('name')
                ->get();
        }

        return jsonResponse($sellers);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response|string
     */
    public function store(Request $request)
    {
        $recordExists = Seller::where('name', $request->input('name'))
            ->exists();

        if ($recordExists) {
            return response('Already exists', 409);
        }

        $seller = Seller::create($request->all());

        $clientIds = Client::all('id')->pluck('id');
        $seller->clients()->sync($clientIds);
        $seller->types()->sync(range(1, 11));

        return jsonResponse($seller);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Seller $seller
     * @return string
     */
    public function update(Request $request, Seller $seller)
    {
        $seller->update($request->all());

        return 'Success';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Seller $seller
     * @return string
     * @throws Exception
     */
    public function destroy(Seller $seller)
    {
        $seller->delete();

        return 'Success';
    }
}

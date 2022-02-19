<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class GeneralController extends Controller
{
    /**
     * List of all editable data.
     *
     * @return JsonResponse
     */
    public function lists()
    {
        return jsonResponse(config('ini_data.lists'));
    }
}
